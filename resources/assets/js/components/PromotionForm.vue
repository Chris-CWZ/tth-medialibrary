<template>
    <form @submit.prevent="validateForm">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group has-label">
                    <label>Type
                        <span class="star">*</span>
                    </label>
                    <select class="form-control" name="type" v-model="type" @change="onChange()" :disabled="disabled == 1">
                        <option disabled>Select type</option>
                        <option value="percentage">Percentage discount</option>
                        <option value="fixed">Fixed discount</option>
                        <option value="bundled">Bundled product discounts</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label">
                    <label>Promo code
                        <span class="star">*</span>
                    </label>
                    <input type="text" class="form-control" name="code" v-model="code" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label">
                    <label>Usage limit</label>
                    <input type="number" class="form-control" name="code" v-model="usageLimit">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label">
                    <label>Start date
                        <span class="star">*</span>
                    </label>
                    <datetime v-model="startDate" value-zone="UTC+8" type="datetime" input-class="form-control"
                        title="Choose date & time"></datetime>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label">
                    <label>Expiry date
                        <span class="star">*</span>
                    </label>
                    <datetime v-model="expiryDate" value-zone="UTC+8" type="datetime" input-class="form-control"
                        title="Choose date & time"></datetime>
                </div>
            </div>
        </div>
        <div class="row" v-if="type == 'percentage'">
            <div class="col-md-4">
                <div class="form-group has-label percentage-form">
                    <label>Discount percentage (%)
                        <span class="star">*</span>
                    </label>
                    <input type="number" class="form-control" name="discount_percentage" v-model="discountPercentage"
                        required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-label percentage-form">
                    <label>Discount cap amount (RM)</label>
                    <input type="number" class="form-control" name="cap_amount" v-model="capAmount">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group has-label percentage-form">
                    <label>Minimum spending (RM)</label>
                    <input type="number" class="form-control" name="min_spending" v-model="minSpending">
                </div>
            </div>
        </div>
        <div class="row" v-else-if="type == 'fixed'">
            <div class="col-md-6">
                <div class="form-group has-label fixed-form">
                    <label>Discount amount (RM)
                        <span class="star">*</span>
                    </label>
                    <input type="number" class="form-control" name="discount_amount" v-model="discountAmount" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label fixed-form">
                    <label>Minimum spending (RM)</label>
                    <input type="number" class="form-control" name="min_spending" v-model="minSpending">
                </div>
            </div>
        </div>
        <div class="row" v-else-if="type == 'bundled'">
            <div class="col-md-12">
                <div class="form-group has-label bundled-form">
                    <label>Fill in either one:</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label bundled-form">
                    <label>Discount percentage (%)</label>
                    <input type="number" class="form-control" name="disocunt_percentage" v-model="discountPercentage">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group has-label bundled-form">
                    <label>Discount amount (RM)</label>
                    <input type="number" class="form-control" name="discount_amount" v-model="discountAmount">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group has-label bundled-form">
                    <label>Products in bundle</label>
                    <multiselect v-model="selectedProducts" :options="options" :multiple="true" :close-on-select="false"
                        :clear-on-select="false" :preserve-search="true" placeholder="Pick some" label="name"
                        track-by="name" :preselect-first="false">
                        <template slot="selection" slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">
                                {{ values.length }} products selected
                            </span>
                        </template>
                    </multiselect>
                </div>
            </div>
            <div class="col-md-12 mx-4 my-4">
                <strong>Products selected:</strong>
                <p v-if="selectedProducts == null">None</p>
                <ol>
                    <li v-for="(selectedProduct, index) in selectedProducts" v-bind:key="index">
                        {{ selectedProduct.name }}</li>
                </ol>
            </div>
        </div>
        <div class="card-category form-category">
            <span class="star">*</span> Required fields
        </div>
        <div class="alert alert-danger mt-4" role="alert" v-if="errors.length">
            <ul>
                <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
            </ul>
        </div>
        <div class="card-footer text-right">
            <button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
        </div>
    </form>
</template>

<script>
    import {Datetime} from 'vue-datetime'
    import 'vue-datetime/dist/vue-datetime.css'
    import Multiselect from 'vue-multiselect'
    import moment from 'moment'

    export default {
        props: ["promotion"],

        data: function () {
            return {
                code: null,
                type: null,
                startDate: null,
                expiryDate: null,
                usageLimit: null,
                discountPercentage: null,
                discountAmount: null,
                capAmount: null,
                options: [],
                selectedProducts: null,
                minSpending: null,
                errors: [],
                disabled: null
            };
        },

        mounted() {
            this.fillForm()
        },

        components: {
            datetime: Datetime,
            Multiselect
        },

        methods: {
            onChange() {
                if (this.type == 'bundled') {
                    axios.get("/admin/promotions/get/products")
                    .then(({data}) => {
                        this.options = Object.values(data)
                    }, (error) => {
                        console.log(error.response)
                    });
                }
            },

            validateForm: function () {
                console.log(this.startDate)

                this.errors = []

                var startDateInput = moment(this.startDate.date)
                var expiryDateInput = moment(this.expiryDate.date)

                if (moment(this.startDateInput).isAfter(this.expiryDate)) {
                    this.errors.push('Starting date cannot be later than expiry date')
                }

                if (!this.startDate) {
                    this.errors.push('Enter a starting date')
                }

                if (!this.expiryDate) {
                    this.errors.push('Enter an expiry date')
                }

                if (!this.discountPercentage && !this.discountAmount) {
                    this.errors.push('Either a discount percentage or a fixed amount is required')
                } else if (this.discountPercentage && this.discountAmount) {
                    this.errors.push('Only either fill in a discount percentage or a fixed amount')
                }
                
                if (this.type == 'bundled') {
                    if (this.selectedProducts == null) {
                        this.errors.push('Select at least 2 products')
                    } else if (this.selectedProducts.length <= 1) {
                        this.errors.push('At least 2 products required to create a bundle')
                    }
                }

                if (this.errors.length == 0) {
                    if (this.promotion == null) {
                        this.createPromotion()
                    } else {
                        this.updatePromotion()
                    }
                }
            },

            createPromotion: function () {
                var data = {
                    'code': this.code,
                    'type': this.type,
                    'start_date': this.startDate,
                    'expiry_date': this.expiryDate,
                    'usage_limit': this.usageLimit,
                    'discount_percentage': this.discountPercentage,
                    'discount_amount': this.discountAmount,
                    'cap_amount': this.capAmount,
                    'min_spending': this.minSpending,
                    'selected_products': this.selectedProducts
                }

                console.log(data);

                axios.post("/admin/promotions", data)
                    .then(({data}) => {
                        location.href = data
                    }, (error) => {
                        console.log(error.response)

                        if(error.response.status == 422) {
                            this.errors.push('A promo code with that name already exists')
                        }

                    });
            },

            updatePromotion: function () {
                var data = {
                    'code': this.code,
                    'type': this.type,
                    'start_date': this.startDate,
                    'expiry_date': this.expiryDate,
                    'usage_limit': this.usageLimit,
                    'discount_percentage': this.discountPercentage,
                    'discount_amount': this.discountAmount,
                    'cap_amount': this.capAmount,
                    'min_spending': this.minSpending,
                    'selected_products': this.selectedProducts
                }

                console.log(data);

                axios.put("/admin/promotions/" + this.promotion.id, data)
                    .then(({data}) => {
                        location.href = data
                    }, (error) => {
                        console.log(error.response)

                        if(error.response.status == 422) {
                            this.errors.push('An error occurred')
                        }

                    });
            },

            fillForm: function() {
                if(this.promotion != null) {
                    this.code = this.promotion.code
                    this.type = this.promotion.type
                    this.startDate = moment(this.promotion.start_date).utc().format("YYYY-MM-DDTHH:mm:ss.SSS[Z]");
                    this.expiryDate = moment(this.promotion.expiry_date).utc().format("YYYY-MM-DDTHH:mm:ss.SSS[Z]");
                    this.usageLimit = this.promotion.usage_limit
                    this.discountPercentage = this.promotion.discount_percentage * 100
                    this.discountAmount = this.promotion.discount_amount
                    this.capAmount = this.promotion.cap_amount
                    this.minSpending = this.promotion.min_spending
                    this.disabled = 1
                }
            },
        }
    }

</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>