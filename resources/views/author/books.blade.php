<x-app-layout>
    <div class="container">
        <!--Grid row-->
        <div class="row">
          <!--Grid column-->
            <div class="col-md-9 mb-4">
                <section style="padding-top: 25px;">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-header">
                            My Books
                        </div>
                        <div class="card-body">
                            <hr/>
                                <!-- Post -->
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div class="bg-image hover-overlay shadow-1-strong rounded ripple" data-mdb-ripple-color="light">
                                            <img src="https://mdbootstrap.com/img/new/standard/nature/184.jpg" class="img-fluid" />
                                            <a href="#!">
                                                <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="col-md-8 mb-4">
                                        <h4>
                                            Very long post title
                                        </h4>
                                        <span class="text-muted small mb-0">
                                            Shared publicly - Jan 2020
                                        </span>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatibus ratione
                                            necessitatibus itaque error alias repellendus nemo reiciendis aperiam quisquam
                                            minus ipsam reprehenderit commodi ducimus, in dicta aliquam eveniet dignissimos
                                            magni.
                                        </p>
                                        <hr/>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <a href="#!" class="link-muted me-1" style="padding-right: 20px;">
                                                    <i class="bi bi-hand-thumbs-up"></i>
                                                    158
                                                </a>
                                                <a href="#!" class="link-muted" style="padding-right: 20px;">
                                                    <i class="bi bi-eye me-1"></i>
                                                    13
                                                </a>
                                                <a href="#!" class="link-muted" style="padding-right: 20px;">
                                                    <i class="bi bi-chat-right me-1"></i>
                                                    13
                                                </a>
                                                <a href="#!" class="link-muted" style="padding-right: 20px;">
                                                    <i class="bi bi-download me-1"></i>
                                                    13
                                                </a>
                                            </div>
                                            <a href="#!" class="link-muted"><i class="bi bi-gear me-1"></i> Options</a>
                                        </div>
                                        <hr/>
                                    </div>
                                </div>
                        </div>
                    </div>
                </section>
            </div>
            <!--Grid column-->

            <!--Grid column-->
            <div class="col-md-3 mb-4">
                <section style="padding-top: 25px;">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-header">
                            New Publishment
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </section>
            </div>
            <!--Grid column-->
        </div>
        <!--Grid row-->
    </div>
</x-app-layout>
