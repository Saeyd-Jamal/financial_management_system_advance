<div class="container-fluid  p-0">
    <h3>تعديلات الموظف : <span id="employee_name"></span></h3>
    <div class="row mx-0">
        <!-- Bordered table -->
        <div class="col-12 my-4 p-0">
            <div class="card shadow">
                <div class="card-body p-0">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="bg-dark">
                            <tr>
                                <th>التعديل</th>
                                <th>دفعة شهرية</th>
                                <th>يناير</th>
                                <th>فبراير</th>
                                <th>مارس</th>
                                <th>أبريل</th>
                                <th>مايو</th>
                                <th>يونيو</th>
                                <th>يوليه</th>
                                <th>أغسطس</th>
                                <th>سبتمبر</th>
                                <th>أكتوبر</th>
                                <th>نوفمبر</th>
                                <th>ديسمبر</th>
                            </tr>
                        </thead>
                        <tbody id="loans_tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div> <!-- Bordered table -->
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-between">
            <div>
                <div class="d-flex align-items-center">
                    <span class="h5">إجمالي قرض الإدخار : </span>
                    <x-form.input name="savings_loan_total" style="width: 121px;" type="number" step="0.01" min="0" />
                </div>
                <span>المتبقي بعد الخصم : <span class="text-danger" id="savings_loan_total_span"></span></span>
            </div>
            <div>
                <div class="d-flex align-items-center">
                    <span class="h5">إجمالي قرض الجمعية : </span>
                    <x-form.input name="association_loan_total" style="width: 121px;" type="number" step="0.01" min="0" />
                </div>
                <span>المتبقي بعد الخصم : <span class="text-danger" id="association_loan_total_span"></span></span>
            </div>
            <div>
                <div class="d-flex align-items-center">
                    <span class="h5">إجمالي قرض اللجنة (الشيكل) : </span>
                    <x-form.input name="shekel_loan_total" style="width: 121px;" type="number" step="0.01" min="0" />
                </div>
                <span>المتبقي بعد الخصم : <span class="text-danger" id="shekel_loan_total_span"></span></span>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end" id="btns_form">
        <button aria-label="" type="button" class="btn btn-danger px-2" data-bs-dismiss="modal" aria-hidden="true">
            <span aria-hidden="true">×</span>
            إغلاق
        </button>
        <button type="button" id="update" class="btn btn-primary mx-2">
            <i class="fa-solid fa-edit"></i>
            تعديل
        </button>
    </div>
</div>
