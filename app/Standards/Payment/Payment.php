<?php

namespace App\Standards\Payment;


use App\Data\Addresses\AddressDataAttributes;
use App\Data\Classifiers\ClassifierData;
use App\Data\Orders\OrderDataAttributes;
use App\Data\Payments\PaymentHistoryDataAttributes;
use App\Http\Requests\Payments\PaymentRequest;
use App\Repositories\Classifiers\ClassifierRepository;
use App\Repositories\Orders\OrderRepository;
use App\Repositories\Payments\PaymentAddressRepository;
use App\Repositories\Payments\PaymentHistoryRepository;
use App\Repositories\ShippingAddresses\ShippingAddressRepository;
use App\Standards\Enums\ClassifierModel;
use App\Standards\Enums\ErrorMessage;
use App\Standards\Enums\SettingKey;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * Provides the logic for the Payment process.
 */
class Payment
{
    /**
     * @var PaymentRequest
     */
    protected PaymentRequest $request;

    /**
     * @var OrderDataAttributes
     */
    protected OrderDataAttributes $orderData;

    /**
     * @var PaymentHistoryDataAttributes
     */
    protected PaymentHistoryDataAttributes $paymentHistoryData;

    /**
     * @param PaymentRequest $request
     */
    public function __construct(PaymentRequest $request)
    {
        $this->request = $request;

        $this->orderData = new OrderDataAttributes($request->all());
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $this->baseProcessing();

        $this->paymentProcessing();

        $this->shippingProcessing();

        $this->paymentHistoryProcessing();

        $this->createProcessing();
    }

    /**
     * @return void
     */
    public function createProcessing(): void
    {
        DB::beginTransaction();

        $order = OrderRepository::query()->write($this->orderData);

        $this->paymentHistoryData->order_id = $order->id;

        $paymentHistory = PaymentHistoryRepository::query()->write($this->paymentHistoryData);

        DB::commit();
    }

    /**
     * @return string
     */
    public function generateToken(): string
    {
        return Hash::make(Str::random(40));
    }

    /**
     * @return void
     */
    public function baseProcessing(): void
    {
        $this->orderData->user_id = user()->id;

        $this->orderData->total = cart()->getTotal();
    }

    /**
     * @return void
     */
    public function paymentProcessing(): void
    {
        $paymentAddress = $this->getAddress(PaymentAddressRepository::class, 'payment_address');

        $this->orderData->payment_address_id = $paymentAddress->id;

        $this->orderData->payment_address_name = $paymentAddress->name;

        $this->orderData->payment_method_name = $this->getPaymentMethod()->name;
    }

    /**
     * @return void
     */
    public function paymentHistoryProcessing(): void
    {
        $this->paymentHistoryData = new PaymentHistoryDataAttributes([ 'user_id' => user()->id ]);

        $paymentStatus = $this->getPaymentStatus();

        $this->paymentHistoryData->new_payment_status_id = $paymentStatus->id;

        $this->paymentHistoryData->new_payment_status_name = $paymentStatus->name;

        $this->paymentHistoryData->token = $this->generateToken();
    }

    /**
     * @return void
     */
    public function shippingProcessing(): void
    {
        $shippingAddress = $this->getAddress(ShippingAddressRepository::class, 'shipping_address');

        $this->orderData->shipping_address_id = $shippingAddress->id;

        $this->orderData->shipping_address_name = $shippingAddress->name;

        $this->orderData->shipping_method_name = $this->getShippingMethod()->name;

        $shippingStatus = $this->getShippingStatus();

        $this->orderData->shipping_status_id = $shippingStatus->id;

        $this->orderData->shipping_status_name = $shippingStatus->name;
    }

    /**
     * @return ClassifierData
     */
    public function getPaymentMethod(): ClassifierData
    {
        $record = ClassifierRepository::forModel(ClassifierModel::PAYMENT_METHOD->value)->find($this->orderData->payment_method_id);

        return ClassifierData::fromModel($record);
    }

    /**
     * @return ClassifierData
     */
    public function getPaymentStatus(): ClassifierData
    {
        $record = ClassifierRepository::forModel(ClassifierModel::PAYMENT_STATUS->value)->find(SettingKey::DEFAULT_PAYMENT_STATUS_ID->data()->value);

        return ClassifierData::fromModel($record);
    }

    /**
     * @param class-string<PaymentAddressRepository|ShippingAddressRepository> $repository
     * @param string $baseName
     *
     * @return ClassifierData
     */
    public function getAddress(string $repository, string $baseName): ClassifierData
    {
        if (!isset($this->orderData->{ $baseName . '_id' }) && !isset($this->orderData->{ $baseName . '_name' }))
        {
            throw new \LogicException(ErrorMessage::INVALID_DATA->value);
        }

        $record = $repository::query()->find($this->orderData->{ $baseName . '_id' } ?? 0);

        if (!$record)
        {
            $name = $this->orderData->{ $baseName . '_name' };

            $attributes = new AddressDataAttributes([ 'user_id' => user()->id, 'code' => Str::slug($name), 'name' => $name, ]);

            $record = $repository::query()->write($attributes);
        }

        return ClassifierData::fromModel($record);
    }

    /**
     * @return ClassifierData
     */
    public function getShippingMethod(): ClassifierData
    {
        $record = ClassifierRepository::forModel(ClassifierModel::SHIPPING_METHOD->value)->find($this->orderData->shipping_method_id);

        return ClassifierData::fromModel($record);
    }

    /**
     * @return ClassifierData
     */
    public function getShippingStatus(): ClassifierData
    {
        $record = ClassifierRepository::forModel(ClassifierModel::SHIPPING_STATUS->value)->find(SettingKey::DEFAULT_SHIPPING_STATUS_ID->data()->value);

        return ClassifierData::fromModel($record);
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->paymentHistoryData->token;
    }
}
