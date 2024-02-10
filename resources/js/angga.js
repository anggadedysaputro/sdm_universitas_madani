export default class Angga {
    static rupiah(number) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            minimumFractionDigits: 0,
            currency: "IDR"
        }).format(number).replace('Rp', '').trim();
    }

    static initializeDatePickerIndoView() {
        $.fn.datepicker.dates['en'] = {
            days: ["Minggu", "Senin", "Selasa", "Rabu", "Kamin", "Jum'at", "Sabtu"],
            daysShort: ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"],
            daysMin: ["Min", "Sen", "Se", "Ra", "Ka", "Ju", "Sa"],
            months: ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                "September", "Oktober", "November", "Desember"
            ],
            monthsShort: [
                "Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Des"
            ],
            today: "Hari Ini",
            clear: "Kosongkan",
            titleFormat: "MM yyyy",
            format: "dd MM yyyy",
            weekStart: 0,
            autoclose: true
        };
    }

    static initializeDatePicker() {
        $('.datepicker').datepicker({
            orientation: "bottom",
            autoclose: true,
            format: "dd MM yyyy"
        });
    }

    static initializeMaskMoney() {
        $('.money-mask').attr('maxlength', '22').inputmask('numeric', {
            radixPoint: ",",
            allowMinus: false,
            regex: "[0-9]*",
            groupSeparator: ".",
            rightAlign: false,
            allowZero: true,
            digits: 0,
            min: 0,
            alias: 'numeric',
            onBeforeMask: function (value, opts) {
                value = parseFloat(value.toString().split(".")[0]) ?? 0;
                return value;
            },
        });

        $('.numerical-custom-mask').inputmask("numeric", { allowMinus: false });
        $('.numerical-mask').attr('maxlength', '22').inputmask("numeric", {
            allowMinus: false, "oncleared": function () {
                $(this).val(0);
            }
        });
        $('.kodebarang-mask').inputmask('99.99.99.99.99.99.999');
        $('.kodebarang-mask-end').inputmask('99.99.99.99.99.99.999');
    }

    static setValueSelect2AjaxRemote(select, data) {
        // Set the value, creating a new option if necessary
        if (select.find("option[value='" + data.id + "']").length) {
            select.val(data.id).trigger('change');
        } else {
            // Create a DOM Option and pre-select by default
            var newOption = new Option(data.text, data.id, true, true);
            // Append it to the select
            select.append(newOption).trigger('change');
        }
    }

    static normalNumeric(currentvalue) {
        return parseFloat(currentvalue.toString().replace(/\./g, ''));
    }

    static fixedNumeric(currentvalue) {
        return parseFloat(currentvalue).toFixed(0);
    }

    static bindEventValidation(form, listExcludeValid = []) {
        $.each(form[0].elements, function (index, element) {
            if (!listExcludeValid.includes(element.name)) {
                $(this).removeClass('is-valid');
                if (element.nodeName == 'INPUT' || element.nodeName == 'SELECT' || element.nodeName == 'TEXTAREA') {
                    $(element).on('change', function () {
                        if ($(this).val() == '') {
                            $(this).removeClass('is-valid');
                            $(this).nextAll('.invalid-feedback').text('Perlu diisi!');
                        } else {
                            $(this).removeClass('is-invalid').addClass('is-valid');
                        }
                    });
                }
            }
        });
    }

    static trNotFound(colspan, isi) {
        let content = `
            <tr class="trnotfound">
                <td colspan="${colspan}" class="text-center">
                    ${isi}
                </td>
            </tr>
        `;

        return content;
    }

    static backToTop(element) {
        element.parent().removeClass('visually-hidden');
        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                element.fadeIn();
            } else {
                element.fadeOut();
            }
        });
        // scroll body to 0px on click
        element.click(function () {
            $('body,html').animate({
                scrollTop: 0
            }, 400);
            return false;
        });
    }

    static throttle(f, delay) {
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

    static pathInfo(str) {
        const lastDot = str.lastIndexOf('.'); // exactly what it says on the tin
        return str.slice(0, lastDot); // char
    }

    static defaultImgUser() {
        return 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAYAAAA6/NlyAAAACXBIWXMAAAsTAAALEwEAmpwYAAAF30lEQVR4nO2aC0xTVxjH/9OOGLM4zJYtxixbwnAMFR3WtqJwgT10MhcnEt1ctkXn5lScio8NqajABowxDAsIbeUVisMFkALybMGZbeo0TmTgFvcyi7pNUTQi2vZbzgW0lDf09l4y/sk/ue25/b7vd849596eFhjVqIak/BC4aDgsSPVFQqwKhlgVvo9R4ESkHEc2eyEzxA3LALhiJCs/CJM1HLLSOVxO50Ba/76d5IO7m7xw1u0RLAYgw0hRaiA8NRxOa/1h7Q+yJ6fMgyXYDZUAPCBlRXIYp+FQoeGGBmprDQd6wx0/AFBBqtofgJXDBbWH3jgD1jgVbms4nNP4IYp1KiQk95UeOK0dwHwdqJN9Qeung/b53esEBv8uJCIXANtXeaBB40DoHd4g9ayu7+k4qCERPbTkKdRvmwlKcxB04lzQmqn3R7nD1gxOAouaJgAfs8LCZoA2eoGS5w0fOGku6D1PUJyq2xw/LTYvNP641bnghHu3j0y0AjSQ+7C9dS+Op6RFU3hY1nkpvnbA/qC9CzBBNFitL4Lsi45XgT6YCgplC0/QZNIGjO0fdMFEylr5POXu2EoZWzaQevbYXjtMx2GTeMActD0VleIHivabSPqIcMoND6Ps1UGUEexOuvkTSMc6IPBB0i18lDKXP0c565eTXr2D9DsjqCLhM/r7UCEd2fRyXx2ULxqwjkNJj6MQ8ABd0MXR9bJSOqVNp6KYaB6oJ+fvjqSjXybTpaICojoT7xvFByhr/viegTkcFQ1Y44/m7rBjqDEx7F7xzNZaI10xFNP5PD01ZGVSY04W/XpAT/8UF/Fttud2+o/0GNof2MN0CECzeMAcrtkW89Vrk+ivjIQeAYbiC7p4yg1ytV+pr0kCuCF+A5mryx0G2+k7laVUH7vWdqUWdYSbOgtxNKi9bUa4Vkzg2v8VcM5C12+NoYF0POJ1gYGNfA6Wi+UUBZbq6vxaDx+yCj2y9uZzmkzzRACuvehs2HuuNV50OrDZVOP00e00y+104JbDZWaxgK8fLjU7HbgwJqrJtghrnVHAS7jr64I9exqdDiyTyT78es+uX5pLDBaqNVJbTaVgl3hbdZWV5WC58ndF/iyTyUKdDgzgcQBRAJKZ/zUcEuwSZ7E783TkfAwiaRwAHwBLG7L2XxUKuCEz4yrL0ZFLGruYeWp1nVDA+oiII5Ca5np6vt1aVeHwecxistiQoJ4sjf30d0cDl8TF/sZiQ4pye2JS+JUSg8MWr6slBjOLCQnLbamfX2FbTdWwYe8aq+nN+S8YWExIXItjVq/6zmIa+oOIxVRD8evWHGexMAI0BsC6vaGhJ82mmiHAGiktbDPbcN/QEWtEyAXAlo9WrKi7VTnwlZutyJHvvMV2JbdL5n7bp0LIBQpaByWdgLytBR6Vloen5dJP2Zl0u7qyV1DWxnYyXafrCc+UWSBvbYGSjkNJawGS4j8DSAYlpUJBd6Ekum8rwauBDu7eRXmRaqpOTKBj+1LoTIaO97G0FKpO/JxvY/vT8Kpv/4xtDBZTRSnSAZ9DPlDSza6gXd1aVUFNOdlkTEqkwugoytup5s2Oa75I5NvYOX3FgIJuwptE/neAitZAQZY+C1US3ajsf8W+Xm7sG7jdFqjofXFg51AQlGQdQJFkSq/oF7hmXz8jfN8s5xLnws6mKd3na+9+NaS0X+CgpWUDBWa+Ax9y4gOJkhoGURxh2kn6ZJuhV9jorQbCtFODAWZz+oxzYBX00qAKY559mzCliBYFF5AxrZxuVhl5s+NXggv4Nv6cwcZl08oJwPWDLoxZ3kLwKCc8re9q9p78xuDjMavoR4FpaQwUZB5ScbytBO/LBK/GdrPjIcfiL2szX5NgktOyYRUohBXEtn4EkoISRAfs7njhgOXNBgkAdvWs5mLhgGf+eUp0QHvPvHBSQODzZ6QHfF7A+7HXubOiA9qb1SQccJMEgZtGgR0n94PZePabS5Iyq0lALbH5UUsqdvJXxVGNClLSfwR1oWP/DWTeAAAAAElFTkSuQmCC';
    }

    static generalAjaxOptions(url, method,) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: url,
                type: 'GET',
                headers: { 'referrer-policy': '*' },
                beforeSend: function () {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": true,
                        "positionClass": "toast-top-center",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": 10,
                        "hideDuration": 10,
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                        "progressBar": true,
                    };
                    toastr.warning(textLoading);
                },
                success: function (data) {
                    toastr.clear();
                    resolve(data);
                },
                error: function (data) {
                    reject(data);
                }
            });
        });
    }

    static generalAjaxSelect2(url, placeholder, modal = false) {

        let select2Object = {
            theme: 'bootstrap-5',
            placeholder,
            allowClear: true,
            ajax: {
                dataType: 'json',
                url,
                method: "POST",
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: function (params) {
                    var query = {
                        search: params.term,
                        type: 'public',
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data) {
                    return {
                        results: data.results,
                        pagination: data.pagination
                    };
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: function (data) {
                let content = `
                    <div class="d-flex justify-content-between">
                        <span>
                            ${data.text}
                        </span>
                        ${data.hasOwnProperty('icon') ? `<i class="${data.icon}"></i>` : ``}
                    </div>
                `;
                return content;
            },
            templateSelection: function (data) {
                return "<span class='ms-4'>" + data.text + "</span>";
            }
        }

        return (modal ? $.extend(select2Object, { dropdownParent: modal.find('.modal-content') }) : select2Object);
    }

    static childRowsDataTable() {
        return {
            type: 'column',
            renderer: function (api, rowIdx, columns) {
                let data = columns.map((col, i) => {
                    let row = api.row(rowIdx).node();
                    return col.hidden
                        ? '<tr data-dt-row="' +
                        col.rowIndex +
                        '" data-dt-column="' +
                        col.columnIndex +
                        '">' +
                        '<td>' +
                        col.title +
                        ':' +
                        '</td> ' +
                        '<td class="' + $(row).find('td:nth(' + col.columnIndex + ')').attr('class') + '">' +
                        col.data +
                        '</td>' +
                        '</tr>'
                        : '';
                }).join('');

                let table = document.createElement('table');
                table.innerHTML = data;

                return data ? table : false;
            }
        }
    }
}