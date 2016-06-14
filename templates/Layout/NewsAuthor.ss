<% with $NewsAuthor %>
  <div class="news-author-meta">
    <h1 class="news-author-title"><span>News by</span> $FullName</h1>
  </div><!-- news-author-meta -->
  <% if PaginatedNews %>
    <% include NewsExcerpts %>
  <% end_if %>
  <% if PaginatedNews.MoreThanOnePage %>
      <% include NewsPagination %>
  <% end_if %>
<% end_with %>

