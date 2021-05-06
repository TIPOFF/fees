<?php

declare(strict_types=1);

namespace Tipoff\Fees\Nova;

use \Tipoff\Fees\Models\Fee as FeeModel;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use Tipoff\Support\Enums\AppliesTo;
use Tipoff\Support\Nova\BaseResource;

class Fee extends BaseResource
{
    public static $model = FeeModel::class;

    public static $title = 'name';

    public static $search = [
        'id',
        'name',
        'title',
    ];

    public static $group = 'Operations Units';

    public function fieldsForIndex(NovaRequest $request)
    {
        return array_filter([
            ID::make(),
            Text::make('Name')->sortable(),
            Number::make('Amount')->sortable(),
            Number::make('Percent')->sortable(),
        ]);
    }

    public function fields(Request $request)
    {
        return array_filter([
            Text::make('Name (Internal)', 'name')->rules('required'),
            Text::make('Title (What Customers See)', 'title')->rules('required'),
            Slug::make('Slug')->from('Title')->rules('required'),
            Number::make('Amount')->sortable()
                ->rules(function () {
                    return [
                        'required_if:percent,null,0',
                    ];
                }),
            Number::make('Percent')->nullable()
                ->rules(function () {
                    return [
                        'required_if:amount,null,0',
                    ];
                }),
            Select::make('Applies To')->options([
                AppliesTo::BOOKING => 'Each Booking in Order',
                AppliesTo::PARTICIPANT => 'Each Participant in Bookings',
                AppliesTo::PRODUCT => 'Each Product in Order',
                AppliesTo::BOOKING_AND_PRODUCT => 'Each Booking & Product in Order',
            ])->required()->displayUsingLabels(),
            Boolean::make('Is Taxed', 'is_taxed'),

            new Panel('Data Fields', $this->dataFields()),

            nova('location_fee') ? HasMany::make('Location Booking Fee', 'locationBookingFees', nova('location_fee')) : null,
            nova('location_fee') ? HasMany::make('Location Product Fee', 'locationProductFees', nova('location_fee')) : null,
            nova('booking') ? HasMany::make('Bookings', 'bookings', nova('booking')) : null,
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
        );
    }

    protected static function afterValidation(NovaRequest $request, $validator)
    {
        $percent = $request->post('percent');
        $amount = $request->post('amount');

        if (! empty($amount) && ! empty($percent)) {
            $validator
                ->errors()
                ->add(
                    'amount',
                    'A fee cannot have both an amount & percent.'
                );
            $validator
                ->errors()
                ->add(
                    'percent',
                    'A fee cannot have both an amount & percent.'
                );
        }
    }
}
