<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<style>
    .bd-example-modal-lg .card-header {
        padding: 10px 10px;
        font-weight: 600;
    }

    .bd-example-modal-lg .card-body {
        padding: 10px;
    }

    .modal-content {
        border-radius: 10px;
    }

    .modal-dialog {
        max-width: 1000px;
    }
</style>
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4" id="myLargeModalLabel">Car Details</h5>
                <button type="button" class="close" onclick="closeModal()">&times;</span></button>
            </div>
            <div class="modal-body modal-card-light">
                <div class="row">
                    <div class="col-md-12">
                        @if ($pro && count($pro) > 0)
                            <div class='card'>
                                <p class="card-header">Details</p>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped">
                                            <tr>
                                                <th>Brand</th>
                                                <td>{{ $pro[0]['brandName'] }}</td>
                                                <th>Model</th>
                                                <td>{{ $pro[0]['modelName'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <td>{{ $pro[0]['year'] }}</td>
                                                <th>Fuel Type</th>
                                                <td>{{ $pro[0]['fuelName'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Color</th>
                                                <td>{{ $pro[0]['colorName'] }}</td>
                                                <th>Transmission</th>
                                                <td>{{ $pro[0]['transmissionName'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Body Type</th>
                                                <td>{{ $pro[0]['bodyName'] }}</td>
                                                <th>Seat</th>
                                                <td>{{ $pro[0]['seat'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Car Range</th>
                                                <td>{{ $pro[0]['carRange'] }}</td>
                                                <th>Battery Capacity</th>
                                                <td>{{ $pro[0]['batteryCapacity'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Contract Length</th>
                                                <td>{{ $pro[0]['contractLength'] }}</td>
                                                <th>Price</th>
                                                <td>{{ $pro[0]['price'] }}</td>
                                            </tr>
                                            <tr>
                                                <th>Offer Price (if available)</th>
                                                <td>{{ $pro[0]['offerPrice'] }}</td>
                                                <th>Deposit</th>
                                                <td>{{ $pro[0]['deposit'] }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class='card'>
                                <p class="card-header">Car Images</p>
                                <div class="card-body">
                                    <div class="row">
                                        @if (!empty($pro[0]['images']))
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Images</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- @for ($i = 0; $i < count($pro[0]['images']); $i++) --}}
                                                        <tr>
                                                            <td>
                                                                <div class="row">
                                                                    @foreach (json_decode($pro[0]['images']) as $image)
                                                                        <div class="col-md-2">
                                                                            <a class="thumbnail fancybox" rel="ligthbox" href="{{ url(config('constants.carPicPath')) . '/' . $pro[0]['id'] . '/' . $image }}">
                                                                                <img src="{{ url(config('constants.carPicPath')) . '/' . $pro[0]['id'] . '/' . $image }}" class="img-fluid">
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        {{-- @endfor --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
    function closeModal() {
        jQuery('#myModal').modal('hide');
        setTimeout(function() {
            jQuery('#myModal').remove();
            jQuery('modal-backdrop').remove();
        }, 500);
    }
    $(document).ready(function() {
        $(".fancybox").fancybox({
            openEffect: "none",
            closeEffect: "none"
        });
    })
</script>
