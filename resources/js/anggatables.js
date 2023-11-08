export default class AnggaTables {
    containerSearch;
    containerTampilBaris;
    globalSearch = ""; // PNP customizeable
    containerPaging;
    containerIsi;
    container;
    link;
    startFrom;
    jumlahMax;
    value;
    result;
    columns;
    allowTotal;

    constructor(value) {
        //initialize value
        this.value = value;
        this.containerSearch = value.containerSearch;
        this.containerTampilBaris = value.containerTampilBaris;
        this.containerPaging = value.containerPaging;
        this.containerIsi = value.containerIsi;
        this.container = value.container;
        this.nodata = value.nodata;
        this.link = value.request.url;
        this.startFrom = 0;
        this.columns = value.columns;
        this.allowTotal = value.allowTotal || false;
        this.value.createdRow = value.createdRow || (function (row, data) { });
        this.value.request.data = value.request.data || (function (data) { return data; });
        this.customSearchView = value.customSearchView || false;

        this.componentPaging().componentSearch(value.placeholderSearch || '').componentTampilBaris().bindEvent().setViewToContainer();

    }

    setViewToContainer() {
        let that = this;
        this.containerIsi.html("");
        this.callAjaxForFilter(this.link, that.value.request.data(this.transformFilteredValue())).then((result) => {
            that.result = result;
            if (that.result.data.length == 0) {
                let content = `
                    <div class="p-2 text-center border-1 border border-light fs-6">
                        <div>Data tidak ditemukan!</div>
                    </div>
                `;
                this.nodata = this.nodata || content;
                that.containerIsi.html(this.nodata);
            } else {
                result.data.forEach((data) => {
                    let row = that.makeView(that.value.content(data));
                    row.addClass('simenik-tables-data').data(data);
                    that.value.createdRow(row, data);
                });
            }
            that.pagingView(result.recordsFiltered, result.total, result.totalpages);
            that.createBadges(that.jumlahMax);
        }).catch((error) => {
            console.log(error);
            //Swal.fire('ERROR', error.responseJSON.message, 'error');
        });

        return this;
    }

    createBadges(total) {
        let content = `
            <button type="button" class="btn btn-primary btn-sm" fdprocessedid="67e2ll">
                <i class="ti ti-chevron-compact-right"></i>
            </button>
            <button type="button" class="btn btn-outline-primary btn-sm" fdprocessedid="67e2ll" disabled>
                ${total}
            </button>
        `;
        this.containerPaging.find('.next-filter-customizable').html(content);
    }

    makeView(isi) {
        let content = $(isi).appendTo(this.containerIsi.append());

        return content;
    }

    pagingView(recordsFiltered, totalall, totalpages) { // PNP
        let that = this;
        let tampilBaris = parseInt(that.containerTampilBaris.find('select').val());
        that.jumlahMax = (tampilBaris == -1 ? 1 : Math.ceil(recordsFiltered / tampilBaris));
        let pageLength = parseInt(that.containerTampilBaris.find('select').val());
        pageLength = pageLength == -1 ? 1 : pageLength;
        that.containerPaging.find('#filter-customizable-page').text(that.startFrom == 0 ? 1 : that.startFrom + 1);
        that.containerPaging.find('#filter-customizable-record-filtered').text(((pageLength + that.startFrom) >= recordsFiltered ? recordsFiltered : pageLength + that.startFrom));
        that.containerPaging.find("#filter-customizable-record-total").text(recordsFiltered);
        that.containerPaging.find('.next-filter-dataaset .badge').text(that.jumlahMax);
        if (that.allowTotal) that.containerPaging.find('#total-customizable-allpages').text(that.numberToCurrencyFormat(totalall.toString()));
        if (that.allowTotal) that.containerPaging.find('#total-customizable-pages').text(that.numberToCurrencyFormat(totalpages.toString()));
        return this;
    }

    transformFilteredValue() { // PNP (customizeable)
        return {
            length: parseInt(this.containerTampilBaris.find('select').val() ?? 0),
            start: this.startFrom,
            columns: this.columns,
            search: {
                value: this.globalSearch == '' ? [] : this.globalSearch,
                regex: false
            }
        }
    }

    componentSearch(placeholder) {
        let contentSearch = `
            <div class="form-inline">
                <div class="input-group">
                <input class="form-control" id="global-search-custumizable"" type="text" placeholder="${placeholder || 'search'}" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar btn-default" fdprocessedid="s3ij5c">
                    <i class="bx search-alt-2"></i>
                    </button>
                </div>
            </div>
        `;

        if (this.customSearchView) contentSearch = this.customSearchView;

        if (this.containerSearch) this.containerSearch.html(contentSearch);
        return this;
    }

    draw() {
        this.setViewToContainer();
    }

    componentTampilBaris() {
        let contentTampilBaris = `
            <select class="form-control form-select" aria-label=".form-select-sm example" fdprocessedid="ezwxa">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="15">15</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="1000">1000</option>
                <option value="-1">All</option>
            </select>
        `;

        if (this.containerTampilBaris) this.containerTampilBaris.html(contentTampilBaris);

        return this;
    }

    componentPaging() {
        let contentPaging = `
            <div class="d-flex flex-wrap justify-content-md-between justify-content-sm-between pagination-filter-customizable flex-column flex-md-row flex-sm-row">
                <small class="text-muted-flex align-self-center font-size-11 flex-wrap flex-column flex-md-row justify-content-center flex-md-grow-1">
                    <p class="m-0">Showing <span id="filter-customizable-page"></span> to <span id="filter-customizable-record-filtered"></span> of <span id="filter-customizable-record-total"></span> entries</p>
                    ${this.allowTotal ? `

                        <p class="m-0">Total <span id="total-customizable-pages"></span> (<span id="total-customizable-allpages"></span> All)</p>
                    ` : ``}

                </small>
                <div class="input-group input-group-sm w-auto f">
                    <span class="input-group-prepend">
                        <button type="button" class="btn btn-outline-primary btn-sm" fdprocessedid="67e2ll" disabled>
                            1
                        </button>
                        <button type="button" class="btn btn-primary btn-sm previous-filter-customizable" fdprocessedid="yfhhmc">
                            <i class="ti ti-chevron-compact-left"></i>
                        </button>
                    </span>
                    <input type="text" class="form-control text-center numerical-mask" id="input-search-paging" value="1" inputmode="decimal" style="text-align: right;" fdprocessedid="wg0bw">
                    <span class="input-group-append next-filter-customizable">
                        
                    </span>
                </div>
            </div>
        `;

        if (this.containerPaging) this.containerPaging.html(contentPaging);
        return this;
    }

    callAjaxForFilter(url, filter) { // PNP
        let that = this;
        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                method: "POST",
                data: filter,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {
                    let content = that.value.contentLoading ??
                        `
                        <p class="text-center">Now loading..</p>
                    `;
                    that.containerIsi.html(content);
                },
                success: function (result) {
                    that.containerIsi.html("");
                    if (result.hasOwnProperty('error')) {
                        reject({ responseJSON: { message: result.error } });
                    } else {
                        resolve(result);
                    }
                },
                error: function (data) {
                    that.containerIsi.html("");
                    reject(data);
                }
            });
        });
    }

    resetPagingStart() { // PNP
        this.startFrom = 0;
        this.jumlahMax = 0;
        this.containerPaging.find('#input-search-paging').val(1);
        return this;
    }

    resetSearchGlobal() {
        if (this.containerSearch) {
            this.containerSearch.find('#global-search-custumizable').val("");
        } else {
            if (this.container) this.container.find('#global-search-custumizable').val("");
        }

        this.globalSearch = "";
        return this;
    }

    bindEvent() {
        let that = this;
        this.containerTampilBaris.find('select').on('change', function () {
            that.resetPagingStart().setViewToContainer();
        });

        this.containerPaging.find('#input-search-paging').on('focus', function () {
            // Store the current value on focus and on change
            let prev = $(this).val();
            $(this).attr('nitip', prev);
        }).off('change').on('change', function () {
            let page = parseInt($(this).val() == "" ? 0 : $(this).val());
            if (page > that.jumlahMax) {
                Swal.fire('PERINGATAN', 'Sudah mencapai batas atas!', 'warning');
                $(this).val($(this).attr('nitip'));
            } else if (page < 1) {
                Swal.fire('PERINGATAN', 'Sudah mencapai batas bawah!', 'warning');
                $(this).val($(this).attr('nitip'));
            } else {
                let tampilBaris = parseInt(that.containerTampilBaris.find('select').val());

                that.startFrom = (page * tampilBaris) - tampilBaris;
                that.setViewToContainer();
            }
        });

        this.containerPaging.find('.previous-filter-customizable').off('click').on('click', function () {
            let searchPosition = that.containerPaging.find('#input-search-paging');
            let prev = parseInt(searchPosition.val()) - 1;

            if (prev > 0) {
                searchPosition.val(prev);
                that.containerPaging.find('#input-search-paging').trigger('change');
            } else {
                Swal.fire('PERINGATAN', 'Batas bawah telah tercapai!', 'warning');
            }
        });

        this.containerPaging.find('.next-filter-customizable').off('click').on('click', function () {
            let searchPosition = that.containerPaging.find('#input-search-paging');
            let next = parseInt(searchPosition.val()) + 1;
            if (next <= that.jumlahMax) {
                searchPosition.val(next);
                that.containerPaging.find('#input-search-paging').trigger('change');
            } else {
                Swal.fire('PERINGATAN', 'Batas atas telah tercapai!', 'warning');
            }
        });

        if (this.containerSearch) {
            this.containerSearch.find('#global-search-custumizable').on('keyup', this.throttle(function () {
                that.globalSearch = $(this).val();
                that.containerPaging.find('#input-search-paging').val(1);
                that.resetPagingStart().setViewToContainer();
            }, 1000));
        } else {
            if (this.container) {
                this.container.find('#global-search-custumizable').on('keyup', this.throttle(function () {
                    that.globalSearch = $(this).val();
                    that.containerPaging.find('#input-search-paging').val(1);
                    that.resetPagingStart().setViewToContainer();
                }, 1000));
            }
        }

        return this;
    }

    data() {
        return this.result.data;
    }

    throttle(f, delay) {
        // untuk delay key up
        // misalnya kamu punya event key up tapi ingin dieksekusi ketika 5 detik
        // setelah keyboard ditekan
        // contoh : 
        // $('#search').keyup(throttle(function(){
        //    do the search if criteria is met
        // },500));
        var timer = null;
        return function () {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = window.setTimeout(function () {
                f.apply(context, args);
            },
                delay || 100);
        };
    }

    numberToCurrencyFormat(str, prefix = "Rp ") {
        let slice = 3;
        let indexIncrement = 0;
        let result = "";
        let number = str.split('.')[0];
        let float = str.split('.')[1];
        if (float != undefined) {
            if (float.length === 1) {
                float = `${float}0`;
            } else if (float.length > 2) {
                if (parseInt(float[2]) > 5) {
                    if (parseInt(float[1]) + 1 == 10) {
                        float = `${parseInt(float[0]) + 1}0`;
                    } else {
                        float = `${float[0]}${parseInt(float[1]) + 1}`;
                    }
                } else {
                    float = `${float[0]}${float[1]}`;
                }
            }
            str = number + '' + float;
        } else {
            str += '.00';
        }

        //  result format if your string is valid
        //  example valid string 1212312312331
        //  the result 12.123.123.123,31

        for (let indexDecrement = str.length; indexDecrement > 0; indexDecrement--) {
            if (indexDecrement == 3) {
                result += ","
            } else if (indexDecrement % slice === 0 && indexDecrement != 0 && indexIncrement != 0) {
                result += "." + str.charAt(indexIncrement);
            } else {
                result += str.charAt(indexIncrement);
            }
            indexIncrement++;
        }
        return prefix + result;
    }
}