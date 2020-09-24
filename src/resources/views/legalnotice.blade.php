@extends ('layouts.default')

@section ('page_title', Settings::getOrgName() . ' - ' . @lang('legalnotice.legalnoticeandprivacy'))

@section ('content')
			
<div class="container">

	<div class="page-header">
		<h1>@lang('legalnotice.legalnoticeandprivacy')</h1> 
	</div>
	<div class="page-header">
		<h3>@lang('legalnotice.legalnoticetitle')</h3> 
	</div>
	{!! Settings::getLegalNotice() !!}
	<div class="page-header">
		<h3>@lang('legalnotice.privacy')</h3> 
	</div>
	{!! Settings::getPrivacyPolicy() !!}
	
</div>

@endsection