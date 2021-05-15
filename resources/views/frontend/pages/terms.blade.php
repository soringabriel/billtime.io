@extends('frontend.layouts.app')

@section('title', __('Terms & Conditions'))

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <x-frontend.card>
                    <x-slot name="header">
                        @lang('Terms & Conditions')
                    </x-slot>

                    <x-slot name="body">
                        <h2>General</h2>
                        <p>
                            The TimoTrack service is an online, subscription-based, hosted, supported and operated on- demand solution (“Cloud Service”) provided by Nifty Software SRL Nifty Software (“NIFTY SOFTWARE”) under a written purchase order.  NIFTY SOFTWARE is who is also the owner of TimoTrack website (www.timotrack.com),it’s contents and the software application. The acceptance of this Terms of Use constitutes the written agreement which is legally binding for both parties and valid until it is terminated by one of the parties. NIFTY SOFTWARE is reserving the right to amend or change the terms of use without prior notice. NIFTY SOFTWARE will however take reasonable steps to inform users about any such change and provide the easy-exit procedure in case of users wishing to terminate the agreement and leave the service at any time, for any reason. NIFTY SOFTWARE is not responsible for the Cloud Service unavailability, data errors, inaccuracies or for any consequential damage caused by the use, or inability to use the Cloud Service.<br>
                            NIFTY SOFTWARE grants to users a non-exclusive, non-transferable and world-wide right to use the Cloud Service (including its implementation and configuration), any materials and documentation solely for user’s internal business operations. Cloud Service may include integrations with web services made available by third parties (other than NIFTY SOFTWARE or its affiliates) that are accessed through the Cloud Service and subject to terms and conditions with those third parties. These third party’s web services are not part of the Cloud Service and the agreement does not apply to them. <br>
                            Support of the Cloud Service is performed in accordance with general terms and conditions of support services.
                        </p>
                        <h2>Personal Information And Privacy</h2>
                        <p>
                            TimoTrack collects personal information from its users and as a service, allows users to collect personal information of other users. According to EU regulation regarding personal data (GDPR) Nifty Software is the processor of the personal data managed by TimoTrack and the User is deemed the controller. Furthermore, these Terms of Use are deemed the Data Processing Agreement required by the regulation. In case the User requires the agreement in a classic paper format signed and dated by both parties, the signed PDF version will be provided on request.<br>
                            NIFTY SOFTWARE is committed to fulfill any request made by the Users stemming from the provisions of personal data protection legislation, upon user’s reasonable request. NIFTY SOFTWARE may charge the user reasonable costs of fulfilling such requests.<br>
                            Personal data is governed by TimoTrack Data Processing Agreement.
                        </p>
                        <h2>Data Security And Safety</h2>
                        <p>
                            NIFTY SOFTWARE takes all reasonable measures to protect the information kept by TimoTrack from unauthorized use and to prevent unauthorized access to TimoTrack and its data. TimoTrack allows its administrative users (admins) to store, process and manage personal information of other users such as employees, temporarily hired workforce, subcontractors and other contributors of their time tracking information. Admins are responsible for protecting the privacy of the personal data they collect and manage with the service. NIFTY SOFTWARE follows best business practices for protecting the user data such as secure communication, data encryption, user identification and authorization, rights management, safe storage and redundancy. All the user information is stored on servers in a secure operating environment. Although NIFTY SOFTWARE has taken all reasonable measures to minimize the risks of data loss NIFTY SOFTWARE takes no responsibility for eventual data recovery failure or data loss in general. To help preserving the data in case of corruption, loss or Cloud Service cancellation NIFTY SOFTWARE allows unhindered export of data during the time of active subscription. NIFTY SOFTWARE is committed to promptly inform the users about all security, privacy and data safety incidents.  <br>
                            User is responsible for its data and entering it into the Cloud Service. User grants to NIFTY SOFTWARE a nonexclusive right to process such data solely to provide and support the Cloud Service.  <br>
                            At the end of the agreement, NIFTY SOFTWARE will delete the user’s data remaining on servers hosting the Cloud Service unless applicable law requires retention.
                        </p>
                        <h2>Subscription Terms</h2>
                        <p>
                            The Cloud service is paid by monthly. The subscription is billed at the beginning of the subscription period. Subscription is billed automatically according to the current number of users. The customer account is billed according to the price listed, the currency available for the country of the user’s origin and the exchange rate used by the checkout system. The subscription can be cancelled at any time by following the Settings link in the global navigation bar. The customer is solely responsible for properly cancelling his account. Email messages are not accepted as cancellation. Nifty Software, in its sole discretion, reserves the right to suspend or terminate any customer account and refuse any and all current or future use of the Cloud service, or any other NIFTY SOFTWARE service, for any reason at anytime. <br>
                            With respect to the Cloud service, user will not:
                        </p>
                        <ul>
                            <li>except to the extent such rights cannot be validly waived by law, disassemble, decompile, reverse-engineer, copy, translate or make derivative works,</li>
                            <li>upload any content or data that is unlawful or infringes any intellectual property rights, or</li>
                            <li>circumvent or endanger its operation or security.</li>
                        </ul>
                        <p>
                            NIFTY SOFTWARE may create analyses utilizing, in part, information derived from user’s use of the Cloud service. Analyses will anonymize and aggregate information, and will be treated as confidential information. Examples of how analyses may be used include: optimizing resources and support; research and development; automated processes that enable continuous improvement, performance optimization and development of new NIFTY SOFTWARE products and services; verification of security and data integrity; internal demand planning; and data products such as industry trends and developments, indices and anonymous benchmarking.<br>
                            NIFTY SOFTWARE warrants that during an applicable subscription term (a) this agreement, and any documentation will accurately describe the applicable administrative, physical and technical safeguards for protection of the security, confidentiality and integrity of user’s data, (b) NIFTY SOFTWARE will not materially decrease the overall security of the Cloud Services, (c) the Cloud Services will perform materially in accordance with the applicable documentation, (d) will not breach registered intellectual property rights of any 3rd party.<br>
                            For any breach of a warranty above, user’s exclusive remedy is termination.  <br>
                            Any liability or warranty as regards the free usage of Cloud Service being free of any material defects and defects in title in excess thereof shall be precluded.<br>
                            NIFTY SOFTWARE shall not be held liable for any loss, including loss of profits, indirect or incidental loss, loss of data, non-function of the Cloud Service or its functionalities if:
                        </p>
                        <ul>
                            <li>loss is not reproducible or not imputable to NIFTY SOFTWARE or in cases where the Cloud Service is not used in compliance with this Agreement;</li>
                            <li>user has failed to properly perform its duty to collaborate or failure to take the advice of NIFTY SOFTWARE ;</li>
                            <li>if the loss is caused as consequence of the force majeure.</li>
                        </ul>
                        <p>
                            NIFTY SOFTWARE ’s total liability for any damages or claims under this agreement is limited to the 10% of the value of the subscription fees paid in the last 6 months, except in case NIFTY SOFTWARE caused the damage with willful intent or gross negligence.
                        </p>
                        <h2>Non-Payment And Dormant Mode</h2>
                        <p>
                            Payment terms are 8 days from the date of the invoice. If TimoTrack subscription is not paid one month after becoming due, the Cloud service falls into dormant mode. In dormant mode, real-time time tracking is still recorded. Dormant accounts are kept in dormant mode for 90 days. During that time, the account can be reactivated simply by paying one-month subscription, where the rate is calculated according to the last month of active use. After 90 days, dormant accounts are automatically cancelled. 
                        </p>
                        <h2>Tax Notes</h2>
                        <p>
                            All the fees are exclusive of all taxes, levies, or duties imposed by taxing authorities. Customers outside EU are responsible for payment of all such taxes, levies, or duties. Customers within EU are treated according to EU tax regulations. 
                        </p>
                        <h2>Governing Law</h2>
                        <p>
                            The Agreement and any claims relating to its subject matter will be governed by and construed under the laws of Romania, without reference to its conflicts of law principles. All disputes will be subject to the exclusive jurisdiction of the courts located in Bucharest. The United Nations Convention on Contracts for the International Sale of Goods and the Uniform Computer Information Transactions Act (where enacted) will not apply to the Agreement.<br>
                            Either party must initiate a cause of action for any claim(s) relating to this agreement and its subject matter within one year from the date when the party knew, or should have known after reasonable investigation, of the facts giving rise to the claim(s).
                        </p>
                        <h2>Validity</h2>
                        <p>
                            Valid from: 07.05.2021<br>
                            This version supersedes all previous versions.
                        </p>
                        <h2>Contact Information</h2>
                        <p>
                            Sorin-Gabriel Marica<br>
                            +40(721)095710<br>
                            info@timotrack.com<br>
                            www.TimoTrack.com
                        </p>
                    </x-slot>
                </x-frontend.card>
            </div><!--col-md-10-->
        </div><!--row-->
    </div><!--container-->
@endsection
