<ul class="pagination">
  <% loop $PaginatedNews.PaginationSummary %>
    <% if $Link %>
      <li <% if $CurrentBool %>class="active"<% end_if %>><a href="$Link">$PageNum</a></li>
    <% else %>
      <li>...</li>
    <% end_if %>
  <% end_loop %>
</ul><!-- pagination -->