<div class="news-item">
	<div class="news-header-wrap">
		<h2 class="news-header">$MenuTitle</h2>
		<p class="meta"><% if Author %><span>by</span> $Author <% end_if %> <span>on</span> $NiceDate</p>
		<% if NewsCategories %>
            <p class="categories">
                <% loop NewsCategories %>
                    <a href="$Link">$Title</a><% if Last %><% else %>, <% end_if %>
                <% end_loop %>
            </p>
        <% end_if %>
		<% if NewsHolder.ShowShare %>
			<div class="share-icons">
				<span class="label">Share</span>
				<ul>
					<% if NewsHolder.ShowFacebook %>
						<div id="fb-root"></div>
						<script>(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=118951841543882";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));</script>
						<li>
							<div class="fb-like" data-href="$AbsoluteLink" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
						</li>
					<% end_if %>
					<% if NewsHolder.ShowTwitter %>
					 	<li>
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="$AbsoluteLink" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
							<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
					 	</li>
					 <% end_if %>
					<% if NewsHolder.ShowGoogle %>
						<li>
							<div class="g-plusone" data-size="tall"></div>
							<script type="text/javascript">
							  (function() {
							    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							    po.src = 'https://apis.google.com/js/platform.js';
							    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
							  })();
							</script>
						</li>
					<% end_if %>
				</ul>
			</div><!-- share-icons -->
		<% end_if %>
	</div><!-- article-header-wrap -->
	<div class="news-content">
		<% if PhotoSized %><img src="$PhotoSized(400).URL" class="news-feature-img" /><% end_if %>
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