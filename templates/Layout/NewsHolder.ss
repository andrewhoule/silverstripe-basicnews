<% if Content %>$Content<% end_if %>
<% if PaginatedNews %>
	<div class="news-excerpts">
		<% loop PaginatedNews %>
			<div class="news-excerpt">
                <% if FeaturePhotoCropped %>
                    <div class="news-thumb">
                        <a href="$Link">
                           <img src="$FeaturePhotoCropped(140,140).URL" alt="MenuTitle" />
                        </a>
                    </div><!-- news-thumb -->
                <% end_if %>
                <div class="news-thumb">
                    <a href="$Link">
                       <img src="$FeaturePhotoCropped(140,140).URL" alt="MenuTitle" />
                    </a>
                </div><!-- news-thumb -->
                <div class="news-info<% if NoFeaturePhoto %> no-photo<% end_if %>">
                    <h2><a href="$Link">$MenuTitle</a></h2>
                    <p class="meta"><% if Author %><span>by</span> $Author <% end_if %> <span>on</span> $NiceDate</p>
                    <% if Top.ShowShare %>
                        <div class="share-icons">
                            <span class="label">Share</span>
                            <ul>
                                <% if Top.ShowFacebook %>
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
                                <% if Top.ShowTwitter %>
                                    <li>
                                        <a href="https://twitter.com/share" class="twitter-share-button" data-url="$AbsoluteLink" data-lang="en" data-related="anywhereTheJavascriptAPI" data-count="vertical">Tweet</a>
                                        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                    </li>
                                 <% end_if %>
                                <% if Top.ShowGoogle %>
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
                    <p>$ContentExcerpt <a href="$Link">Read on &rarr;</a></p>
                </div><!-- news-info -->
            </div><!-- news-excerpt -->
		<% end_loop %>
	</div><!-- news-excerpts -->
<% end_if %>
<% if PaginatedNews.MoreThanOnePage %>
    <div class="pagination-wrap cf">
    <ul id="pagination">   
        <% if PaginatedNews.NotFirstPage %>
            <li class="previous"><a title="<% _t('VIEWPREVIOUSPAGE','View the previous page') %>" href="$PaginatedNews.PrevLink"><% _t('PREVIOUS','&larr;') %></a></li>       
        <% else %>  
            <li class="previous-off"><% _t('PREVIOUS','&larr;') %></li>
        <% end_if %>
        <% loop PaginatedNews.Pages %>
            <% if CurrentBool %>
                <li class="active">$PageNum</li>
            <% else %>
                <li><a href="$Link" title="<% sprintf(_t('VIEWPAGENUMBER','View page number %s'),$PageNum) %>">$PageNum</a></li>        
            <% end_if %>
        <% end_loop %>
        <% if PaginatedNews.NotLastPage %>
            <li class="next"><a title="<% _t('VIEWNEXTPAGE', 'View the next page') %>" href="$PaginatedNews.NextLink"><% _t('NEXT','&rarr;') %></a></li>
        <% else %>
            <li class="next-off"><% _t('NEXT','&rarr;') %> </li>        
        <% end_if %>
    </ul>   
    </div><!-- pagination-wrap cf -->
<% end_if %>