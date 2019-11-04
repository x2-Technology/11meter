<div class="container-fluid">

        <div class="row mt-50 mb-10">
                <div class="col font-mini text-center">
                        <img src="/images/share2.png" width="100" class="image-rotate">
                </div>
        </div>

        <div class="row mt-10 mb-20">
                <div class="col font-mini text-center">
                        Share this Application with Social network
                </div>
        </div>

        <div class="row">
                <ul class="list-group full-width">
                        <li class="full-width list-group-item d-flex justify-content-between position-relative pl-10 pr-5 box-with-border-radius-none action">
                                <a data-role="<?= SHARED_APPLICATION::X2SharedApplicationKey; ?>" data-data="<?= $this->data->{SHARED_APPLICATION::X2SharedApplicationFacebookKey}; ?>" class="show-share font-size-14 full-width text-center text-primary" >
                                        <i class="icon icon-facebook2 pl-10"></i>
                                        Facebook
                                </a>
                        </li>
                        <li class="full-width list-group-item d-flex justify-content-between position-relative pl-10 pr-5 box-with-border-radius-none action">
                                <a data-role="<?= SHARED_APPLICATION::X2SharedApplicationKey; ?>" data-data="<?= $this->data->{SHARED_APPLICATION::X2SharedApplicationTwitterKey}; ?>" class="show-share font-size-14 full-width text-center text-info" >
                                        <i class="icon icon-twitter "></i>
                                        Twitter
                                </a>
                        </li>
                        <li class="full-width list-group-item d-flex justify-content-between position-relative pl-10 pr-5 box-with-border-radius-none action">
                                <a data-role="<?= SHARED_APPLICATION::X2SharedApplicationKey; ?>" data-data="<?= $this->data->{SHARED_APPLICATION::X2SharedApplicationWhatsAppKey}; ?>" class="show-share font-size-14 full-width text-center text-success" >
                                        <i class="icon icon-whatsapp"></i>
                                        Whatsapp
                                </a>
                        </li>

                </ul>
        </div>

</div>