<div class="news-item">
	<div class="news-header-wrap">
		<h2 class="news-header">$MenuTitle</h2>
		<p class="meta"><% if Author %><span>by</span> $Author <% end_if %> <span>on</span> $NiceDate</p>
	</div><!-- article-header-wrap -->
	<div class="news-content">
		<% if PhotoSized %><img src="$PhotoSized(400).URL" class="right" /><% end_if %>
		<% if Content %>$Content<% end_if %>
	</div><!-- news-content -->
</div><!-- news-item -->
<div class="news-nav">
	<div class="news-next-prev">
		<ul>
			<% if PrevNextPage(prev) %>
				<% loop PrevNextPage(prev) %>
					<li class="news-prev"><a href="$Link" title="$MenuTitle" class="button">&larr; Previous</a></li>
				<% end_loop %>
			<% end_if %>
			<% if PrevNextPage(next) %>
				<% loop PrevNextPage(next) %>
					<li class="news-next"><a href="$Link" title="$MenuTitle" class="button">Next &rarr;</a></li>
				<% end_loop %>
			<% end_if %>
		</ul>
	</div><!-- news-prev-next -->
	<div class="news-return">
		<p class="rt"><a href="$Parent.Link">Return to News Page</a></p>
	</div><!-- news-return -->
</div><!-- news-nav -->