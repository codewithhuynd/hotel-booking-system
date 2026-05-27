<!-- SEARCH -->
<div class="search-box">

    <div class="search-head">

        <div>
            <span class="search-subtitle">
                Tìm kiếm nhanh
            </span>

            <h2>
                Tìm phòng phù hợp
            </h2>
        </div>

    </div>

    <form method="GET" action="{{ route('home') }}">

        <div class="search-grid">

            <!-- Keyword -->
            <div class="field">
                <label>
                    <i class="fa-solid fa-bed"></i>
                    Tên phòng
                </label>

                <input
                    type="text"
                    name="keyword"
                    placeholder="Ví dụ: Deluxe Room..."
                    value="{{ request('keyword') }}">
            </div>

            <!-- Price -->
            <div class="field">

                <label>
                    <i class="fa-solid fa-money-bill-wave"></i>
                    Giá phòng
                </label>

                <select name="price">

                    <option value="">
                        Tất cả mức giá
                    </option>

                    <option
                        value="low"
                        {{ request('price') == 'low' ? 'selected' : '' }}>
                        Dưới 500k
                    </option>

                    <option
                        value="medium"
                        {{ request('price') == 'medium' ? 'selected' : '' }}>
                        500k - 1 triệu
                    </option>

                    <option
                        value="high"
                        {{ request('price') == 'high' ? 'selected' : '' }}>
                        Trên 1 triệu
                    </option>

                </select>

            </div>

            <!-- Capacity -->
            <div class="field">

                <label>
                    <i class="fa-solid fa-user-group"></i>
                    Sức chứa
                </label>

                <select name="capacity">

                    <option value="">
                        Tất cả sức chứa
                    </option>

                    <option
                        value="1"
                        {{ request('capacity') == '1' ? 'selected' : '' }}>
                        1 người
                    </option>

                    <option
                        value="2"
                        {{ request('capacity') == '2' ? 'selected' : '' }}>
                        2 người
                    </option>

                    <option
                        value="4"
                        {{ request('capacity') == '4' ? 'selected' : '' }}>
                        4+ người
                    </option>

                </select>

            </div>

            <!-- Status -->
            <div class="field">

                <label>
                    <i class="fa-solid fa-circle-check"></i>
                    Trạng thái
                </label>

                <select name="status">

                    <option value="">
                        Tất cả
                    </option>

                    <option
                        value="available"
                        {{ request('status') == 'available' ? 'selected' : '' }}>
                        Còn trống
                    </option>

                </select>

            </div>

            <!-- Sort Price -->
            <div class="field">

                <label>
                    <i class="fa-solid fa-arrow-up-wide-short"></i>
                    Sắp xếp giá
                </label>

                <select name="sort_price">

                    <option value="">
                        Mặc định
                    </option>

                    <option
                        value="asc"
                        {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                        Giá thấp → cao
                    </option>

                    <option
                        value="desc"
                        {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                        Giá cao → thấp
                    </option>

                </select>

            </div>

            <!-- Sort Time -->
            <div class="field">

                <label>
                    <i class="fa-solid fa-clock"></i>
                    Sắp xếp
                </label>

                <select name="sort_time">

                    <option
                        value="latest"
                        {{ request('sort_time') == 'latest' ? 'selected' : '' }}>
                        Mới nhất
                    </option>

                    <option
                        value="oldest"
                        {{ request('sort_time') == 'oldest' ? 'selected' : '' }}>
                        Cũ nhất
                    </option>

                </select>

            </div>

            <!-- Button -->
            <div class="field search-btn-wrap">

                <label>&nbsp;</label>

                <button
                    type="submit"
                    class="search-btn">

                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm

                </button>

            </div>

        </div>

    </form>

</div>