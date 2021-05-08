 <div class="">
     <div class=" text-center d-none d-md-block ">
         <img src="/storage/images/design/avatarplaceholder.png" width="150" height="150" style="border-radius : 50%"
             alt="">
         <h3 class="mt-3">{{auth()->user()->name}}</h3>
         <h6 class="text-muted">{{auth()->user()->email}}</h6>
     </div>
     <ul class="nav flex-row flex-nowrap flex-md-column px-3 py-4" style="overflow: auto">
         <li class="nav-item {{ request()->is('account/dashboard') ? 'active' : '' }}" >
             <a href="{{ route('account.dashboard') }}" class="nav-link text-dark">
                 <h5> <i class="fa fa-chart-line mr-2"></i>{{__('Dashboard') }}</h5>
             </a>
         </li>
         <li class="nav-item {{ request()->is('account/profile') ? 'active' : '' }}">
             <a href="{{ route('account.profile') }}" class="nav-link text-dark">
                 <h5> <i class="fa fa-user mr-2"></i>{{__('Profile') }}</h5>
             </a>
         </li>

         <li class="nav-item {{ request()->is('account/orders') ? 'active' : '' }}">
             <a href="{{ route('account.orders.index') }}" class="nav-link text-dark">
                 <h5> <i class="fa fa-shopping-bag mr-2"></i>{{__('Orders') }}</h5>
             </a>
         </li>
         <li class="nav-item {{ request()->is('account/addresses') ? 'active' : '' }}">
             <a href="{{ route('account.addresses') }}" class="nav-link text-dark">
                 <h5> <i class="fa fa-address-book mr-2"></i>{{__('Address Book') }}</h5>
             </a>
         </li>
         <li class="nav-item {{ request()->is('account/password') ? 'active' : '' }}">
             <a href="{{route('account.password')}}" class="nav-link text-dark">
                 <h5> <i class="fa fa-key mr-2"></i>{{__('Change Password') }}</h5>
             </a>
         </li>
     </ul>
 </div>
