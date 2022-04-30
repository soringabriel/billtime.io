@extends('frontend.layouts.app')

@section('title', __('FAQ'))

@section('content')
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-4">
                <div class="nav nav-pills faq-nav" id="faq-tabs" role="tablist" aria-orientation="vertical">
                    <a href="#tab1" class="nav-link active" data-toggle="pill" role="tab" aria-controls="tab1" aria-selected="true">
                        <i class="fas fa-question-circle"></i> @lang('Frequently Asked Questions')
                    </a>
                    <a href="#tab2" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab2" aria-selected="false">
                        <i class="far fa-clock"></i> @lang('Time Records')
                    </a>
                    <a href="#tab3" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab3" aria-selected="false">
                        <i class="fas fa-file-invoice-dollar"></i> @lang('Invoices')
                    </a>
                    <a href="#tab4" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab4" aria-selected="false">
                        <i class="fas fa-briefcase"></i> @lang('Team Members')
                    </a>
                    <a href="#tab5" class="nav-link" data-toggle="pill" role="tab" aria-controls="tab5" aria-selected="false">
                        <i class="fas fa-briefcase"></i> @lang('Clients & Projects')
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="tab-content" id="faq-tab-content">
                    <div class="tab-pane show active" id="tab1" role="tabpanel" aria-labelledby="tab1">
                        <div class="accordion" id="accordion-tab-1">
                            <div class="card">
                                <div class="card-header" id="accordion-tab-1-heading-1">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-1" aria-expanded="false" aria-controls="accordion-tab-1-content-1">@lang('What is BillTime.io?')</button>
                                    </h5>
                                </div>
                                <div class="collapse show" id="accordion-tab-1-content-1" aria-labelledby="accordion-tab-1-heading-1" data-parent="#accordion-tab-1">
                                    <div class="card-body">
                                        <p>@lang('BillTime.io is a cloud tool that allows time tracking and billing for companies of all sizes')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-1-heading-2">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-2" aria-expanded="false" aria-controls="accordion-tab-1-content-2">@lang('Who is BillTime.io for?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-1-content-2" aria-labelledby="accordion-tab-1-heading-2" data-parent="#accordion-tab-1">
                                    <div class="card-body">
                                        <p>@lang('BillTime.io it\'s recommended for any company that bills their customer by hour, or any company that wants to have a bigger picture on how time is consumed in their organization')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-1-heading-3">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-3" aria-expanded="false" aria-controls="accordion-tab-1-content-3">@lang('Is BillTime.io free?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-1-content-3" aria-labelledby="accordion-tab-1-heading-3" data-parent="#accordion-tab-1">
                                    <div class="card-body">
                                        <p>@lang('BillTime.io it\'s a free tool that can be used without any card information necessary.')</p>
                                        <p>@lang('By deafult on registration each user gets a free trial of 14 days, while they can use all of the features.')</p>
                                        <p>@lang('After this period they can still use their account, but some of the features will be taken away, unless you opt in for a paid plan')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-1-heading-4">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-4" aria-expanded="false" aria-controls="accordion-tab-1-content-4">@lang('How do I start?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-1-content-4" aria-labelledby="accordion-tab-1-heading-4" data-parent="#accordion-tab-1">
                                    <div class="card-body">
                                        <p>@lang('The first thing you need to is to register on the Sign Up page.')</p>
                                        <p>@lang('After the registration, you will receive an email in order to verify your email address.')</p>
                                        <p>@lang('Once you verified your email you\'re all set and you can start tracking your time')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-1-heading-5">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-1-content-5" aria-expanded="false" aria-controls="accordion-tab-1-content-5">@lang('What plans does BillTime.io offer?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-1-content-5" aria-labelledby="accordion-tab-1-heading-5" data-parent="#accordion-tab-1">
                                    <div class="card-body">
                                        <p>@lang('The list with all of the plans offered by BillTime.io is visible on the page Plan, from the top right corner (for logged in users only)')</p>
                                        <p>@lang('BillTime.io offers plans from 0 to 99$ per month designed to satisfy the needs of companies of any sizes')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="tab2">
                        <div class="accordion" id="accordion-tab-2">
                            <div class="card">
                                <div class="card-header" id="accordion-tab-2-heading-1">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-1" aria-expanded="false" aria-controls="accordion-tab-2-content-1">@lang('How to add a time record?')</button>
                                    </h5>
                                </div>
                                <div class="collapse show" id="accordion-tab-2-content-1" aria-labelledby="accordion-tab-2-heading-1" data-parent="#accordion-tab-2">
                                    <div class="card-body">
                                        <p>@lang('There are two ways of adding a time record, based on the account type you have.')</p>
                                        <p>@lang('If you want to manually add a time record, you should go to Time Records -> Add Manual Time, fill out the form and then Create Time.')</p>
                                        <p>@lang('If you want to use the automatic counter, you should just press the button Start Tracking Time, from the top right corner of the dashboard, and when you finished your work just save your time using the button Stop & Save')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-2-heading-2">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-2" aria-expanded="false" aria-controls="accordion-tab-2-content-2">@lang('What is automatic time tracking?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-2-content-2" aria-labelledby="accordion-tab-2-heading-2" data-parent="#accordion-tab-2">
                                    <div class="card-body">
                                        <p>@lang('Automatic time tracking it\'s a widget offered by BillTime.io that it\'s making time tracking easier.')</p>
                                        <p>@lang('Instead of manually adding the start and the end time for a record, you just start the counter and save the record once you are done working on your task.')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-2-heading-3">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-3" aria-expanded="false" aria-controls="accordion-tab-2-content-3">@lang('Will the timer reset, if I refresh the page?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-2-content-3" aria-labelledby="accordion-tab-2-heading-3" data-parent="#accordion-tab-2">
                                    <div class="card-body">
                                        <p>@lang('No. The automatic time tracker uses cookies in order to remember when you started the counter.')</p>
                                        <p>@lang('This means that even if you change the page, refresh it or close it and come back, the timer will continue without reseting')</p>
                                        <p>@lang('The only exception is if the counter passed 24 hours, in which case the timer will be automatically reset as a time record longer than 24 hours is considered invalid')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-2-heading-4">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-4" aria-expanded="false" aria-controls="accordion-tab-2-content-4">@lang('What is the difference between manual and automatic time tracking?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-2-content-4" aria-labelledby="accordion-tab-2-heading-4" data-parent="#accordion-tab-2">
                                    <div class="card-body">
                                        <p>@lang('In terms of how we store them, none.')</p>
                                        <p>@lang('In terms of how you add them, the manual time is a form where you will fill out both the start and the ending time, whereas the automatic time tracker takes care of this job for you.')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-2-heading-5">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-5" aria-expanded="false" aria-controls="accordion-tab-2-content-5">@lang('How do I export my times?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-2-content-5" aria-labelledby="accordion-tab-2-heading-5" data-parent="#accordion-tab-2">
                                    <div class="card-body">
                                        <p>@lang('BillTime.io accepts exporting the time records as XLSX, XLS and CSV.')</p>
                                        <p>@lang('To export the time records, go on the Time Records List page and on the top right side of the table you will see a button called Export.')
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-2-heading-6">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-2-content-6" aria-expanded="false" aria-controls="accordion-tab-2-content-6">@lang('What does marking my time as billed do?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-2-content-6" aria-labelledby="accordion-tab-2-heading-6" data-parent="#accordion-tab-2">
                                    <div class="card-body">
                                        <p>@lang('This feature is made so that you can easier keep track of your times.')</p>
                                        <p>@lang('Marking a time as billed makes time records easier to filter. It does not mean you no longer have to invoice the hours. The process should rather be, first invoicing the clients and then marking the times as billed')</p>
                                        <p>@lang('If you do associate time records to an invoice, the times will become automatically marked as billed.')</p>
                                        <p>@lang('A time record can be associated to one or more invoices, but as a best practice we recommend associating it to maximum one invoice.')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="tab3">
                        <div class="accordion" id="accordion-tab-3">
                            <div class="card">
                                <div class="card-header" id="accordion-tab-3-heading-1">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-1" aria-expanded="false" aria-controls="accordion-tab-3-content-1">@lang('How do I generate an invoice?')</button>
                                    </h5>
                                </div>
                                <div class="collapse show" id="accordion-tab-3-content-1" aria-labelledby="accordion-tab-3-heading-1" data-parent="#accordion-tab-3">
                                    <div class="card-body">
                                        <p>@lang('To generate an invoice you can go to Invoices -> Create Invoice.')</p>
                                        <p>@lang('On the new page you can fill out all of the data of the invoice.')</p>
                                        <p>@lang('Some of the information may or may not be mandatory.')</p>
                                        <p>@lang('If you want to associate time records to the invoice, you can do so by checking them in the Associated Times tab.')</p>
                                        <p>@lang('Associated times, will be automatically marked as billed once the invoice is created.')</p>
                                        <p>@lang('To speed up the process of creating an invoice, you might choose to preadd the information about your clients in the clients section.')</p>
                                        <p>@lang('Also updating your organization details in the My Account page, will speed up the process, as your company\'s information will be prefilled in the seller section.')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-3-heading-2">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-2" aria-expanded="false" aria-controls="accordion-tab-3-content-2">@lang('I created an invoice. Now, how can I download it?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-3-content-2" aria-labelledby="accordion-tab-3-heading-2" data-parent="#accordion-tab-3">
                                    <div class="card-body">
                                        <p>@lang('Our tool will store all of your invoices on the page Invoices -> Invoices List.')</p>
                                        <p>@lang('In this page you will be able to see all of your invoices, filter them and mark them as paid or past due.')</p>
                                        <p>@lang('To download an invoice, you can use the button Download from the actions column.')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-3-heading-3">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-3" aria-expanded="false" aria-controls="accordion-tab-3-content-3">@lang('In what language are the invoices?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-3-content-3" aria-labelledby="accordion-tab-3-heading-3" data-parent="#accordion-tab-3">
                                    <div class="card-body">
                                        <p class="mb-3">@lang('For the moment the languages are availabe in the following languages:')</p>
                                        <ul>
                                            @foreach (config('boilerplate.locale.invoices_languages') as $locale => $language)
                                                <li>{{ $language }}</li>
                                            @endforeach
                                        </ul>
                                        <p>@lang('However we are continuously looking forward to adding new languages in the list. If you have a suggestion, please let us know, and we will add your language in approximately 48 hours')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-3-heading-4">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-3-content-4" aria-expanded="false" aria-controls="accordion-tab-3-content-4">@lang('What does marking an invoice as past due/paid, do?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-3-content-4" aria-labelledby="accordion-tab-3-heading-4" data-parent="#accordion-tab-3">
                                    <div class="card-body">
                                        <p>@lang('Simillarly with marking times as billed, this feature helps you keep track of your invoices easier.')</p>
                                        <p>@lang('Once you mark an invoice, you can easily filter it out from the invoices with a different state.')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="tab4">
                        <div class="accordion" id="accordion-tab-4">
                            <div class="card">
                                <div class="card-header" id="accordion-tab-4-heading-1">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-1" aria-expanded="false" aria-controls="accordion-tab-4-content-1">@lang('How do I add my team members?')</button>
                                    </h5>
                                </div>
                                <div class="collapse show" id="accordion-tab-4-content-1" aria-labelledby="accordion-tab-4-heading-1" data-parent="#accordion-tab-4">
                                    <div class="card-body">
                                        <p>@lang('To add a team member you just need to go to Team Members -> Add Team Member.')</p>
                                        <p>@lang('In the form you can choose what permissions you want to set for the member.')</p>
                                        <p>@lang('After creating an account, the user will have to verify the email at the given email address, before being able to use the tool')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-4-heading-2">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-2" aria-expanded="false" aria-controls="accordion-tab-4-content-2">@lang('How many team members can I add?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-4-content-2" aria-labelledby="accordion-tab-4-heading-2" data-parent="#accordion-tab-4">
                                    <div class="card-body">
                                        <p>@lang('This depends on the plan of your organization. During the free 14 days trial, you can add an unlimited number of users.')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-4-heading-3">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-4-content-3" aria-expanded="false" aria-controls="accordion-tab-4-content-3">@lang('What happens to my team members if I downgrade to a plan with less number of users?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-4-content-3" aria-labelledby="accordion-tab-4-heading-3" data-parent="#accordion-tab-4">
                                    <div class="card-body">
                                        <p>@lang('Downgrading to a plan with less users than the current one, can lead to some of your team members not being able to access their account anymore')</p>
                                        <p>@lang('The rule is that if the number of team members is bigger than the number of users your new plan has, the surplus of team members will be deleted.')</p>
                                        <p>@lang('However, the deletion of these users it\'s not permanent, and you can restore them from you deleted users page, once you have enough quota left.')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab5" role="tabpanel" aria-labelledby="tab5">
                        <div class="accordion" id="accordion-tab-5">
                            <div class="card">
                                <div class="card-header" id="accordion-tab-5-heading-1">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-1" aria-expanded="false" aria-controls="accordion-tab-5-content-1">@lang('What is a client?')</button>
                                    </h5>
                                </div>
                                <div class="collapse show" id="accordion-tab-5-content-1" aria-labelledby="accordion-tab-5-heading-1" data-parent="#accordion-tab-5">
                                    <div class="card-body">
                                        <p>@lang('The client records keep track of your company\'s clients, the persons that you\'re working with')</p>
                                        <p>@lang('Keeping track of your clients it\'s useful, as it optimizez the process of billing them and it can be a way to filter out your time records')</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" id="accordion-tab-5-heading-2">
                                    <h5>
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#accordion-tab-5-content-2" aria-expanded="false" aria-controls="accordion-tab-5-content-2">@lang('What is a project?')</button>
                                    </h5>
                                </div>
                                <div class="collapse" id="accordion-tab-5-content-2" aria-labelledby="accordion-tab-5-heading-2" data-parent="#accordion-tab-5">
                                    <div class="card-body">
                                        <p>@lang('Projects represent your company\'s real projects and they are used to associate your time records to relevant categories of work')</p>
                                        <p>@lang('Each project has to have a client associated to it')</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
