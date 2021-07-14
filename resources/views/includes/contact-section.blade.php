<section id="contact" class="contact">
    <div class="container" >

        <div class="section-title">
            <h2>{{__('Contact')}}</h2>
            <p>{{__('Contact Us')}}</p>
        </div>
    </div>
    <div class="container" >

        <div >
            <iframe style="border:0; width: 100%; height: 350px;"
                src="https://maps.google.com/maps?q={{config('app.contact.address')}}&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0"
                allowfullscreen></iframe>

        </div>
        <div class="row mt-5">

            <div class="col-md-12">
                <div class="info d-flex justify-content-between flex-wrap">
                    <div class="address">
                        <i class="icofont-google-map"></i>
                        <h4>{{__('Location')}}:</h4>
                        <p>{{config('app.contact.address')}}</p>
                    </div>

                    {{-- <div class="open-hours">
                        <i class="icofont-clock-time icofont-rotate-90"></i>
                        <h4>{{__('Open Hours')}}:</h4>
                    <p>
                        Monday-Saturday:<br>
                        11:00 AM - 2300 PM
                    </p>
                </div> --}}

                <div class="email">
                    <i class="icofont-envelope"></i>
                    <h4>{{__('Email')}}:</h4>
                    <p>{{config('app.contact.email')}}</p>
                </div>

                <div class="phone">
                    <i class="icofont-phone"></i>
                    <h4>{{__('Phone')}}:</h4>
                    <p>{{config('app.contact.phone')}}</p>
                </div>

            </div>

        </div>


    </div>

    </div>
</section>
