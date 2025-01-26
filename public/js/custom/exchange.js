(function ($) {
    $(".employee_fields_search").on("input", function (e) {
        let employeeId = $('#employee_id_search').val();
        let employeeName = $('#employee_name_search').val();
        $.ajax({
            url: app_link + "employees/getEmployee", //data-id
            method: "get",
            data: {
                employeeId: employeeId,
                employeeName: employeeName,
                _token: csrf_token,
            },
            success: function (response) {
                $("#table_employee").empty();
                if (response.length != 0) {
                    for (let index = 0; index < response.length; index++) {
                        $("#table_employee").append(
                            "<tr class='employee_select' data-id=" +response[index]["id"] +"><th scope='row'>" +
                                response[index]["id"] +
                                "</th><td>" +
                                response[index]["employee_id"] +
                                "</td><td>" +
                                response[index]["name"] +
                                "</td><td>" +
                                response[index]["date_of_birth"] +
                                "</td></tr>"
                        );
                    }
                }else{
                    $("#table_employee").append(
                        "<tr><td colspan='3'>يرجى التأكد من صحة البيانات</td></tr>"
                    );
                }
            },
        });
    });
    $(".table-hover").delegate("tr.employee_select", "click", function () {
        let employee_id_select = $(this).data("id");
        $("input[name=employee_id]").val(employee_id_select);
        $("#searchEmployee .close").click();
        $.ajax({
            url: app_link + "exchanges/getTotals", //data-id
            method: "post",
            data: {
                employeeId: employee_id_select,
                _token: csrf_token,
            },
            success: function (response) {
                $("#employee_name").empty();
                $("#employee_name").text(response['name']);
                $('#employee_id').val(employee_id_select);
                $(".totals").text('');
                $('#total_receivables').text(response['total_receivables']);
                $('#total_savings').text(response['total_savings']);
                $('#total_association_loan').text(response['total_association_loan']);
                $('#total_savings_loan').text(response['total_savings_loan']);
                $('#total_shekel_loan').text(response['total_shekel_loan']);
            },
        });
    });

    function exchange_type() {
        let exchange_type = $("#exchange_type").val();
        let inp = '';
        $('#exchange_div').empty();
        $('#total_savings_span').empty();
        $('#total_receivables_span').empty();

        if(exchange_type == 'receivables_discount'){
            inp = `
            <div class="form-group p-3 col-4" id="receivables_discount_div">
                <label for="receivables_discount">قيمة المستحقات المخصومة</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${receivables_discount}" id="receivables_discount" name="receivables_discount" required placeholder="قيمة المستحقات المخصومة"/>
                <span class="warning text-danger" id="receivables_discount_span_warning"></span>
            </div>
            `;
        }
        if(exchange_type == 'receivables_addition'){
            inp = `
            <div class="form-group p-3 col-4" id="receivables_addition_div">
                <label for="receivables_addition">قيمة المستحقات المضافة</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${receivables_addition}" id="receivables_addition" name="receivables_addition" required placeholder="قيمة المستحقات المضافة"/>
                <span class="warning text-danger" id="receivables_addition_span_warning"></span>
            </div>
            `;
        }
        if(exchange_type == 'savings_discount'){
            inp = `
            <div class="form-group p-3 col-4" id="savings_discount_div">
                <label for="savings_discount">قيمة الإدخارات المخصومة $</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${savings_discount}" id="savings_discount" name="savings_discount" required placeholder="قيمة الإدخارات المخصومة"/>
                <span class="warning text-danger" id="savings_discount_span_warning"></span>
            </div>
            `;
        }
        if(exchange_type == 'savings_addition'){
            inp = `
            <div class="form-group p-3 col-4" id="savings_addition_div">
                <label for="savings_addition">قيمة الإدخارات المضافة $</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${savings_addition}" id="savings_addition" name="savings_addition" required placeholder="قيمة الإدخارات المضافة"/>
                <span class="warning text-danger" id="savings_addition_span_warning"></span>
            </div>
            `;
        }
        if(exchange_type == 'association_loan'){
            inp = `
            <div class="form-group p-3 col-4" id="association_loan_div">
                <label for="association_loan">قيمة القرض الجمعية ش</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${association_loan}" id="association_loan" name="association_loan" required placeholder="قيمة القرض الجمعية"/>
            </div>
            `;
        }
        if(exchange_type == 'savings_loan'){
            inp = `
            <div class="form-group p-3 col-4" id="savings_loan_div">
                <label for="savings_loan">قيمة القرض الإدخار $</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${savings_loan}" id="savings_loan" name="savings_loan" required placeholder="قيمة القرض الإدخار"/>
            </div>
            `;
        }
        if(exchange_type == 'shekel_loan'){
            inp = `
            <div class="form-group p-3 col-4" id="shekel_loan_div">
                <label for="shekel_loan">قيمة القرض اللجنة ش</label>
                <input type="number" min="0" step="0.01" class="form-control" value="${shekel_loan}" id="shekel_loan" name="shekel_loan" required placeholder="قيمة القرض اللجنة"/>
            </div>
            `;
        }

        $('#exchange_div').append(inp);
    };

    exchange_type();
    $("#exchange_type").on('change',exchange_type);

    $(document).on('input', '#receivables_discount , #savings_discount, #receivables_addition, #savings_addition, #association_loan, #savings_loan, #shekel_loan', function () {
        let name = $(this).attr('name');
        if(name == 'receivables_discount'){
            let total_receivables = parseFloat($('#total_receivables').text());
            let receivables_discount = $('#receivables_discount').val();
            $('#total_receivables_span').text(`(${(total_receivables - receivables_discount).toFixed(2)})`);
            if(receivables_discount > total_receivables){
                $('#receivables_discount_span_warning').text('قيمة خصم المستحقات أكثر من المستحقات الإجمالية لديه يمكن الخصم لكن سيكون على الموظف سالب')
            }else{
                $('#receivables_discount_span_warning').text('')
            }
        }

        if(name == 'receivables_addition'){
            let total_receivables = parseFloat($('#total_receivables').text());
            let receivables_addition = parseFloat($('#receivables_addition').val());
            $('#total_receivables_span').text(`(${(total_receivables + receivables_addition).toFixed(2)})`);
        }

        if(name == 'savings_discount'){
            let total_savings = parseFloat($('#total_savings').text());
            let savings_discount = $('#savings_discount').val();
            $('#total_savings_span').text(`(${(total_savings - savings_discount).toFixed(2)})`);
            if(savings_discount > total_savings){
                $('#savings_discount_span_warning').text('قيمة خصم الإدخارات أكثر من الإدخارات الإجمالية لديه يمكن الخصم لكن سيكون على الموظف سالب')
            }else{
                $('#savings_discount_span_warning').text('')
            }
        }
        if(name == 'savings_addition'){
            let total_savings = parseFloat($('#total_savings').text());
            let savings_addition = parseFloat($('#savings_addition').val());
            $('#total_savings_span').text(`(${(total_savings + savings_addition).toFixed(2)})`);
        }

        if(name == 'association_loan'){
            let total_association_loan = parseFloat($('#total_association_loan').text());
            let association_loan = parseFloat($('#association_loan').val());
            $('#total_association_loan_span').text(`(${(total_association_loan + association_loan).toFixed(2)})`);
        }
        if(name == 'savings_loan'){
            let total_savings_loan = parseFloat($('#total_savings_loan').text());
            let savings_loan = parseFloat($('#savings_loan').val());
            $('#total_savings_loan_span').text(`(${(total_savings_loan + savings_loan).toFixed(2)})`);
        }
        if(name == 'shekel_loan'){
            let total_shekel_loan = parseFloat($('#total_shekel_loan').text());
            let shekel_loan = parseFloat($('#shekel_loan').val());
            $('#total_shekel_loan_span').text(`(${(total_shekel_loan + shekel_loan).toFixed(2)})`);
        }
    });


})(jQuery);
