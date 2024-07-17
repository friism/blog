<form role="search" method="get"
    action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search"
        placeholder="Search" aria-label="Search" value="<?php echo esc_attr( get_search_query() ); ?>"
        name="s">
    <button type="submit">Search</button>
</form>
