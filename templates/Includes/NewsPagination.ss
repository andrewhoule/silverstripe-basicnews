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