@component('mail::message')
# Introduction

{{__('admin.' .$event_name  ,
 [
     'orderId' => $order->id ,
     "orderStatus" => __('admin.' . $order->status),
     "orderTotal" => $order->total
  ])}}

@component('mail::button', ['url' => config('app.url') . $url])
{{__("Check out")}}
@endcomponent

{{__('Thanks')}}<br>
{{ config('app.name') }}
@endcomponent
