<x-app-layout>
    <div class="container" style="padding-top: 25px;">
        <!--Grid row-->
        <div class="row">
            <div class="col-md-12">
                <iframe src="{{asset('documents')}}/{{$book->document}}" height="550" width="1100" title="{{$book->title}}"></iframe>
            </div>
        </div>
    </div>
</x-app-layout>
