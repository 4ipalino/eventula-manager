@extends ('layouts.default')

@section ('content')

<div id="hero-carousel" class="carousel fade" data-ride="carousel" data-interval="8000">
	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		@foreach ($sliderImages as $image)
			<div class="item @if ($loop->first) active @endif">
				<img class="hero-image" alt="{{ Settings::getOrgName() }} Banner" src="{{ $image->path }}">
			</div>
		@endforeach
	</div>
	<div class="hero-overlay hidden-xs">
			@if ($nextEvent)
				<div>
					<h3>@lang('messages.next_event')</h3>
					<h1>{{ $nextEvent->display_name }}</h1>
					<h5>{{ date('dS', strtotime($nextEvent->start)) }} - {{ date('dS', strtotime($nextEvent->end)) }} {{ date('F', strtotime($nextEvent->end)) }} {{ date('Y', strtotime($nextEvent->end)) }}</h5>
					<a href="/events/{{ $nextEvent->slug }}#tickets"><button class="btn btn-orange btn-lg">@lang('messages.book_now')</button></a>
				</div>
			@else
				<div>
					<h3>@lang('messages.next_event')</h3>
					<h1>@lang('home.comingsoon')</h1>
				</div>
			@endif
		</div>
	</div>
	
</div>

<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
			<div class="page-header">
				<h3>@lang('home.about') {{ Settings::getOrgName() }}</h3>
			</div>
			<p>{!! Settings::getAboutShort() !!}</p>
		</div>
		<div class="hidden-xs hidden-sm hidden-md col-lg-4">
			<div class="page-header">
				<h3>@lang('home.eventcalendar')</h3>
			</div>
			@if ( count($events) > 0 )
				<table class="table table-borderless">
					<tbody>
						@foreach ( $events as $event )
							@if ($event->start > \Carbon\Carbon::today() )
								<tr>
									<td>
										<a href="/events/{{ $event->slug }}">
											{{ $event->display_name }}
											@if ($event->status != 'PUBLISHED')
												- {{ $event->status }}
											@endif
										</a>
									</td>
									<td>
										<span class="pull-right">
											{{ date('dS', strtotime($event->start)) }} - {{ date('dS', strtotime($event->end)) }} {{ date('F', strtotime($event->end)) }} {{ date('Y', strtotime($event->end)) }}
										</span>
									</td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>
			@else
				<div>@lang('home.comingsoon')...</div>
			@endif
		</div>
		@if ($nextEvent)
			<div class="col-xs-12">
				<div class="page-header">
					<h3>
						{{ $nextEvent->display_name }}
						@if (count($nextEvent->seatingPlans) > 0)
							<small>{{ max($nextEvent->getSeatingCapacity() - $nextEvent->eventParticipants->count(), 0) }} / {{ $nextEvent->getSeatingCapacity() }} @lang('home.seatsremaining')</small>
						@else 
							<small>{{ max($nextEvent->capacity - $nextEvent->eventParticipants->count(), 0) }} / {{ $nextEvent->capacity }} @lang('home.ticketsremaining')</small>
						@endif
					</h3>
				</div>
			</div>
			<div class="col-xs-12 col-sm-9">
				<h4>{!! $nextEvent->desc_short !!}</h4>
				<p>{!! $nextEvent->desc_long !!}</p>
			</div>
			<div class="col-xs-12 col-sm-3">
				<h4>@lang('home.when'):</h4>
				<h5>{{ date('dS', strtotime($nextEvent->start)) }} - {{ date('dS', strtotime($nextEvent->end)) }} {{ date('F', strtotime($nextEvent->end)) }} {{ date('Y', strtotime($nextEvent->end)) }}</h5>
				<h4>@lang('home.where'):</h4>
				<h5>{{ $nextEvent->venue->display_name }}</h5>
				@if ($nextEvent->tickets && $user)
					<h4>@lang('home.price'):</h4>
					<h5>@lang('home.ticketsstartfrom') {{ Settings::getCurrencySymbol() }}{{ $nextEvent->getCheapestTicket() }}</h5>
				@endif
			</div>
		@endif
	</div>
</div>
<div class="book-now  text-center hidden-xs">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				@if ($nextEvent)
					<h3>@lang('home.wantgetinaction') <a href="/events/{{ $nextEvent->slug }}" class="text-info">@lang('messages.book_now')</a></h3>
				@else
					<h3>@lang('home.eventscomingsoon')!</h3>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-9">
			<div class="page-header">
				<h3>@lang('home.latestnews')</h3>
			</div>
			@if (!$newsArticles->isEmpty())
				@foreach ($newsArticles as $newsArticle)
					@include ('layouts._partials._news.short')
				@endforeach
			@else
				<p>@lang('home.nothingtosee')...</p>
			@endif
		</div>
		<div class="col-xs-12 col-sm-3">
			<div class="page-header">
				<h3>@lang('home.thefam', ['orgName' => Settings::getOrgName()])</h3>
			</div>
			@if (Settings::getDiscordId())			
				<iframe class="hidden-md" src="https://discordapp.com/widget?id={{ Settings::getDiscordId() }}&theme=light" width="100%" height="500" allowtransparency="true" frameborder="0"></iframe>
			@endif
			@if (count($topAttendees) > 0)
				<div class="page-header">
					<h5>@lang('home.top5attendees')</h5>
				</div>
				@foreach ($topAttendees as $attendee)
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<img class="img-rounded img-responsive" alt="{{ $attendee->username }}'s Avatar" src="{{ $attendee->avatar }}">
						</div>
						<div class="col-xs-12 col-sm-9">
							<p>
								{{ $attendee->username }}<br>
								<small> {{ $attendee->event_count }} @lang('home.eventsattended')</small>
							</p>
						</div>
					</div>
				@endforeach
			@endif
			@if (count($topWinners) > 0)
				<div class="page-header">
					<h5>@lang('home.top5winners')</h5>
				</div>
				@foreach ($topWinners as $winner)
					<div class="row">
						<div class="col-xs-12 col-sm-3">
							<img class="img-rounded img-responsive" alt="{{ $winner->username }}'s Avatar" src="{{ $winner->avatar }}">
						</div>
						<div class="col-xs-12 col-sm-9">
							<p>
								{{ $winner->username }}<br>
								<small> {{ $winner->win_count }} @lang('home.wins')</small>
							</p>
						</div>
					</div>
				@endforeach
			@endif
		</div>
	</div>
</div>

<div class="about  section-padding  section-margin hidden">
	<div class="container">
		<div class="row">
			<div class="col-md-8  col-md-offset-2 text-center">
				<div class="text-center">
					<h2 class="section-heading  text-center">@lang('home.allaboutorg', ['orgName' => Settings::getOrgName() ])</h2>
				</div>
				{!! Settings::getAboutShort() !!}
			</div>
		</div>
	</div>
</div>

@endsection
