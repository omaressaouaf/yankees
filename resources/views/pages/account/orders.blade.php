  @extends('layouts.account')
  @section('account-content')
      <div class="mt-4">
          <h4 class="font-weight-bold"># Latest Orders</h4>
          <p class="text-muted  mb-5">Your recent Purchases</p>
          @foreach ([0, 2, 2] as $item)
              <div class="col-md-12 ">
                  <div class="d-flex" class="order-flex-div">
                      <div class="@if (!$loop->last) col-step @endif">
                          <i class="fa fa-clock bg-success text-light p-2 mr-2 col-step-element"></i>
                      </div>
                      <div class="mx-2">
                          <p class="text-muted">Jan 2th 2020 20:20h</p>
                          <div class="card p-3 mb-4 ">
                              <div class="row">
                                  <div class="col-md-2 pr-0">
                                      <img class="w-100" src="/storage/images/design/avatarplaceholder.png"
                                          alt="Order Items Image">
                                  </div>
                                  <div class="col-md-6">
                                      <h3>
                                          <h1 class="lead ">
                                              2 chicken burgers ....</h1>
                                          <p class="lead text-muted mb-2">Order 2442412</p>
                                          <a class="btn-link" data-toggle="collapse" href="#multiCollapseExample1"
                                              role="button" aria-expanded="false"
                                              aria-controls="multiCollapseExample1">Details</a>


                                          <div class="collapse" id="multiCollapseExample1">
                                              <ul class="mt-2 px-0" style="list-style: none">
                                                  <li>1 x Cheese burger <span class="float-right">20dh</span> </li>
                                                  <li>2 x Pizza margareta <span class="float-right">30dh</span> </li>
                                                  <li class="font-weight-bold mt-2 text-success">Total (tva included)  <span class="float-right ">30dh</span>  </li>
                                              </ul>
                                          </div>


                                      </h3>

                                  </div>
                                  <div class="col-md-2">
                                      <h4> <span class="badge badge-primary tag ">Pending</span> </h4>
                                  </div>
                              </div>

                          </div>
                      </div>
                  </div>
              </div>
          @endforeach
      </div>
  @endsection
