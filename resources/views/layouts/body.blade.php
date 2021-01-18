<div id="login">
    <h3 class="text-center text-white pt-5 title-test">Rastreamento por objeto</h3>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12">
                    <form class="form" action="" method="post">
                        <div class="form-group">
                            <input type="text" name="number" id="number" class="form-control">
                        </div>
                    </form>
                </div>
            </div>
            <div class="w-100"></div>
            <div class="col-md-6 but-calc">
                <button type="button" id="calcule" class="btn btn-primary mr-2">Rastrear</button>
                <img style="width:10%; border-radius:50%; display: none;" id="calcule2" src="{{asset('assets/img/loading.gif')}}" alt="">
            </div>
        </div>
        <div class="row justify-content-center align-items-center">
            <div class="col-md-6">
                <div class="col-md-12" id="result">
                    <!-- <p class="numberResult" ></p> -->

                </div>
            </div>
        </div>
    </div>
</div>