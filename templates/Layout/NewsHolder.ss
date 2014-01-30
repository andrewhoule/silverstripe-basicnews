<% if Content %>$Content<% end_if %>
<% if PaginatedNews %>
    <% include NewsExcerpts %>
<% end_if %>
<% if PaginatedNews.MoreThanOnePage %>
    <% include NewsPagination %>
<% end_if %>