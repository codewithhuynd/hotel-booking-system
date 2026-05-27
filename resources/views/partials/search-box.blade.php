<!-- SEARCH -->
<div class="search-box">

    <div class="search-head">

        <h2>
            Tìm phòng phù hợp
        </h2>

    </div>

    <form
        method="GET"
        action="{{ route('home') }}">

        <div class="search-grid">

            <div class="field">

                <label>
                    Tên phòng
                </label>

                <input
                    type="text"
                    name="keyword"
                    placeholder="Tên phòng..."
                    value="{{ request('keyword') }}">

            </div>

            <div class="field">

                <label>
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

            <div class="field">

                <label>
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

            <div class="field">

                <label>
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

            <div class="field">

                <label>
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

            <div class="field">

                <label>
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

            <div class="field">

                <label>
                    &nbsp;
                </label>

                <button
                    type="submit"
                    class="btn btn-dark"
                    style="width:100%;">
                    Tìm kiếm
                </button>

            </div>

        </div>

    </form>

</div>
