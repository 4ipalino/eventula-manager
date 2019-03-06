<div class="news-post">
	<h2 class="news-post-title"><a href="/news/{{ $news_article->slug }}">{{ $news_article->title }}</a></h2>
	<br>
	{!! strip_tags(substr($news_article->article, strpos($news_article->article, "<p"), strpos($news_article->article, "</p>")+4)) !!}
	<br><br>
	<p><a href="/news/{{ $news_article->slug }}">Read More...</a></p>
	<hr>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<a href="https://www.facebook.com/sharer/sharer.php?u={{ url('/news') }}/{{ $news_article->slug }}&t={{ $news_article->title }}" target="_blank">Share</a>
		</div>
		<div class="col-xs-12 col-sm-6">
			<!-- // TODO - add user account public pages -->
			<p class="news-post-meta pull-right">{{ date('F d, Y', strtotime($news_article->created_at)) }} by <a href="#">{{ $news_article->user->steamname }}</a></p>
		</div>
	</div>
</div>