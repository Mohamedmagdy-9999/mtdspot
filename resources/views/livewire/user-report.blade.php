<div>
    <div class="card custom-card">
        <div class="card-header border-bottom">
            <h3 class="card-title">Users Paied Report</h3>
        </div>
        <div class="card-body">
            <div class="row row-sm">
                <div class="col-lg-6 col-xl-6 col-sm-12">
                    <div class="input-group my-1">
                            <div class="input-group-text bg-primary-transparent text-primary">
                                Date from:
                            </div>
                            <input class="form-control" wire:model="from" id="dateMask" placeholder="MM/DD/YYYY" type="date">
                    </div><!-- input-group -->
                </div><!-- col-4 -->
                <div class="col-lg-6 col-xl-6 col-sm-12">
                    <div class="input-group my-1">
                            <div class="input-group-text bg-primary-transparent text-primary">
                                Date to:
                            </div>
                            <input class="form-control" wire:model="to" id="Text1" placeholder="MM/DD/YYYY" type="date">
                    </div><!-- input-group -->
                </div>
            </div>
            <div class="table-responsive">
                <table class="table border text-nowrap text-md-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Total</th> 
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key=> $item)
                           
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$item->name}} {{$item->last_name}}</td>
                                @php 
                               
                                 $total = App\Models\UserOrder::where('user_id', $item->id)->whereBetween('created_at', [$this->from, $this->to])->sum('price');
                               
                                @endphp
                               
                                
                                <td>{{$total}} L.E</td> 
                                
                            </tr>
                        @endforeach
                      
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
