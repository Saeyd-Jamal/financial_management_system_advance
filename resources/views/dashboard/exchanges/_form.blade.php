
<div class="row">
    <div class="col-md-8">
        <div class="row">
            <x-form.input  type="hidden" :value="$exchange->employee_id"  name="employee_id" required/>
            <div class="form-group p-3 col-4">
                <x-form.input type="date" label="تاريخ الصرف" :value="$exchange->exchange_date" name="exchange_date" required/>
            </div>
            <div class="form-group p-3 col-4">
                <label for="exchange_type">نوع الصرف</label>
                <select class="form-select" id="exchange_type" name="exchange_type" required>
                    <option value="">تحديد نوع الصرف</option>
                    <option value="receivables_discount" @selected($exchange->exchange_type == 'receivables_discount')>خصم من المستحقات ش</option>
                    <option value="receivables_addition" @selected($exchange->exchange_type == 'receivables_addition')>اضافة للمستحقات ش</option>
                    <option value="savings_discount" @selected($exchange->exchange_type == 'savings_discount')>خصم من الإدخارات $</option>
                    <option value="savings_addition" @selected($exchange->exchange_type == 'savings_addition')>اضافة للإدخارات $</option>
                    <option value="savings_loan" @selected($exchange->exchange_type == 'savings_loan')>قرض إدخار $</option>
                    <option value="shekel_loan" @selected($exchange->exchange_type == 'shekel_loan')>قرض لجنة ش</option>
                    <option value="association_loan" @selected($exchange->exchange_type == 'association_loan')>قرض جمعية ش</option>
                </select>
            </div>
        </div>
        <div class="row" id="exchange_div">
        </div>
        <div class="row">
            <div class="form-group p-3 col-8">
                <x-form.input label="ملاحظات" :value="$exchange->notes" name="notes" placeholder="ملاحظات" />
            </div>
        </div>

    </div>
    <div class="col-md-4">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>الإجمالي</th>
                    <th style="color: #000; background: #dddddd; font-weight: bold;">المبلغ</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>المستحقات</td>
                    <td style="color: #000; background: #dddddd; font-weight: bold;">
                        <span id="total_receivables" class="totals" >
                            {{$exchange->employee->totals->total_receivables ?? 0}}
                        </span>
                        <span id="total_receivables_span" class="text-danger"></span>
                    </td>
                </tr>
                <tr>
                    <td>الإدخارات</td>
                    <td style="color: #000; background: #dddddd; font-weight: bold;">
                        <span id="total_savings" class="totals" >
                            {{$exchange->employee->totals->total_savings ?? 0}}
                        </span>
                        <span id="total_savings_span" class="text-danger"></span>
                    </td>
                </tr>
                <tr>
                    <td>قرض الجمعية</td>
                    <td style="color: #000; background: #dddddd; font-weight: bold;">
                        <span id="total_association_loan" class="totals" >
                            {{$exchange->employee->totals->total_association_loan ?? 0}}
                        </span>
                        <span id="total_association_loan_span" class="text-danger"></span>
                    </td>
                </tr>
                <tr>
                    <td>قرض الإدخار</td>
                    <td style="color: #000; background: #dddddd; font-weight: bold;">
                        <span id="total_savings_loan" class="totals" >
                            {{$exchange->employee->totals->total_savings_loan ?? 0}}
                        </span>
                        <span id="total_savings_loan_span" class="text-danger"></span>
                    </td>
                </tr>
                <tr>
                    <td>قرض اللجنة</td>
                    <td style="color: #000; background: #dddddd; font-weight: bold;">
                        <span id="total_shekel_loan" class="totals" >
                            {{$exchange->employee->totals->total_shekel_loan ?? 0}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="row align-items-center mb-2">
    <div class="col">
        <h2 class="h5 page-title"></h2>
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">
            {{$btn_label ?? "أضف"}}
        </button>
    </div>
</div>
@push('scripts')
<script>
    let receivables_discount = parseFloat("{{$exchange->receivables_discount ?? 0}}");
    let receivables_addition = parseFloat("{{$exchange->receivables_addition ?? 0}}");
    let savings_discount = parseFloat("{{$exchange->savings_discount ?? 0}}");
    let savings_addition = parseFloat("{{$exchange->savings_addition ?? 0}}");
    let association_loan = parseFloat("{{$exchange->association_loan ?? 0}}");
    let savings_loan = parseFloat("{{$exchange->savings_loan ?? 0}}");
    let shekel_loan = parseFloat("{{$exchange->shekel_loan ?? 0}}");
</script>
<script src="{{ asset('js/custom/exchange.js') }}"></script>
@endpush
