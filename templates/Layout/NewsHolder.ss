<% if Content %>$Content<% end_if %>
<% if PaginatedNews %>
	<div class="news-excerpts">
		<% loop PaginatedNews %>
			<div class="news-excerpt">
                <div class="news-thumb">
                    <a href="$Link">
                       <img src="$FeaturePhotoCropped(140,140).URL" alt="MenuTitle" />
                    </a>
                </div><!-- news-thumb -->
                <div class="news-info<% if NoFeaturePhoto %> no-photo<% end_if %>">
                    <h2><a href="$Link">$MenuTitle</a></h2>
                    <p class="meta"><% if Author %><span>by</span> $Author <% end_if %> <span>on</span> $NiceDate</p>
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