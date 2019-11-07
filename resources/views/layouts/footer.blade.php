<section class="siteFooter homeFooter @if($isHome) footerHomePage @else footerHomePage2 @endif">
	<div class="container">
		<div class="row">
			<div class="col-md-6 text-sm-left text-center mb-sm-0 mb-3"> © Copyright African Land Company
			</div>
			<div class="col-md-6 text-sm-right text-center">
				<ul class="footerSocial">
					<li><a href="{{$siteSettings[2]->meta_value}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
					<li><a href="{{$siteSettings[3]->meta_value}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
					<li><a href="{{$siteSettings[4]->meta_value}}" target="_blank"><i class="fa fa-instagram"></i></a></li>
				</ul>
			</div>
		</div>
    </div>
</section>
