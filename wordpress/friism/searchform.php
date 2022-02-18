<form role="search" method="get" class="d-flex"
    action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="form-control me-2"
        placeholder="Search" aria-label="Search" value="<?php echo esc_attr( get_search_query() ); ?>"
        name="s">
    <button class="btn btn-outline-dark" type="submit">Search</button>
</form>
