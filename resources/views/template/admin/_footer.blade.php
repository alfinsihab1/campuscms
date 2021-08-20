<!-- top -->
<a id="top-button" class="btn btn-primary text-white"><i class="fa fa-arrow-up"></i></a>
<!-- fab -->
<div class="fab-wrapper position-fixed d-flex align-items-center justify-content-end text-right" style="bottom: 0; right: 0; z-index: 1;">
	<div class="bg-white shadow-sm px-3 py-2 mr-2" style="width: fit-content; animation: fab 2s infinite ease; border-radius: 1.5em">
		<span class="fw-bold">Contact Us</span>
	</div>
	<a class="fab" href="https://wa.me/{{setting('site.whatsapp')}}" target="blank">
	<div class="rounded-circle shadow-sm float-end text-center d-flex align-items-center justify-content-center mr-2 mb-2 btn-success" style="width: 50px; height: 50px;">
		<i class="fa fa-whatsapp fa-2x"></i>
	</div>
	</a>
</div>
<!-- Footer -->
<footer class="footer text-center">
Copyright &copy; {{ date('Y') }}. All Rights Reserved by <a href="{{ URL::to('/') }}" target="_blank">{{ setting('site.name') }}</a>.
</footer>
<!-- /Footer -->