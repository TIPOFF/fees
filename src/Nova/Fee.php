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
            Text::make('Name (Internal)', 'name')->required(),
            Text::make('Title (What Customers See)', 'title'),
            Slug::make('Slug')->from('Title'),
            Number::make('Amount')->sortable(),
            Number::make('Percent')->nullable(),
            Select::make('Applies To')->options([
                AppliesTo::BOOKING => 'Each Booking in Order',
                AppliesTo::PARTICIPANT => 'Each Participant in Bookings',
                AppliesTo::PRODUCT => 'Each Product in Order',
                AppliesTo::BOOKING_AND_PRODUCT => 'Each Booking & Product in Order',
            ])->required(),
            Boolean::make('Is Taxed', 'is_taxed'),

            new Panel('Data Fields', $this->dataFields()),

            nova('location') ? HasMany::make('Location Booking Fee', 'locationBookingFees', nova('location')) : null,
            nova('location') ? HasMany::make('Location Product Fee', 'locationProductFees', nova('location')) : null,
            nova('booking') ? HasMany::make('Bookings', 'bookings', nova('booking')) : null,
        ]);
    }

    protected function dataFields(): array
    {
        return array_merge(
            parent::dataFields(),
            $this->creatorDataFields(),
            [
                DateTime::make('Updated At')->exceptOnForms(),
            ],
        );
    }
}
