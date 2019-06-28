<form role="search" method="get" class="form-inline ml-auto"
    action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="form-control my-2 mr-sm-2"
        placeholder="search" aria-label="Search" value="<?php echo esc_attr( get_search_query() ); ?>"
        name="s">
    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Search</button>
</form>
