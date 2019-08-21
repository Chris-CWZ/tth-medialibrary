<template>
    <div class="card-body">
        <div class="row mx-1" v-if="promotion.type != 'bundled'">
            <div class="col-lg-12 col-sm-12">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Promotion type</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            {{ type }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-1 mt-2" v-if="promotion.type == 'bundled'">
            <div class="col-lg-6 col-sm-6">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Promotion type</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            {{ type }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-percent" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Discount</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            <span v-if="promotion.discount_amount == null">{{ promotion.discount_percentage * 100 }} %</span>
                            <span v-else>RM {{ promotion.discount_amount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-1 mt-2">
            <div class="col-lg-6 col-sm-6">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Start date</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            {{ promotion.start_date }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>End date</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            {{ promotion.expiry_date }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-1 mt-2" v-if="promotion.type == 'percentage'">
            <div class="col-lg-4 col-sm-4">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-percent" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Discount</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            <h4 class="card-title">
                                {{ promotion.discount_percentage * 100 }} %
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Cap amount</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            <h4 class="card-title">
                                <span v-if="promotion.cap_amount == null">-</span>
                                <span v-else>RM {{ promotion.cap_amount }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-4">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Minimum spending</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            <h4 class="card-title">
                                <span v-if="promotion.min_spending == null">-</span>
                                <span v-else>RM {{ promotion.min_spending }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-1 mt-2" v-if="promotion.type == 'fixed'">
            <div class="col-lg-6 col-sm-6">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-percent" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Discount</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            <h4 class="card-title">
                                RM {{ promotion.discount_amount }}
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Minimum spending</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                        <hr class="mx-2">
                        <div class="stats px-4 mx-2">
                            <h4 class="card-title">
                                <span v-if="promotion.min_spending == null">-</span>
                                <span v-else>RM {{ promotion.min_spending }}</span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mx-1" v-if="promotion.type == 'bundled'">
            <div class="col-lg-12 col-sm-12">
                <div class="card card-stats" style="border:#808080 1px solid">
                    <div class="card-body px-5">
                        <div class="row">
                            <div class="col-5">
                                <div class="icon-big">
                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                </div>
                            </div>
                            <div class="col-7 my-auto">
                                <div class="numbers">
                                    <p class="card-category" style="color:#808080"><b>Products in bundle</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <hr class="mx-2">
                            <div class="stats px-4 mx-2">
                                {{ products.length }} products in bundle
                            </div>
                        <div class="table-responsive px-2">
                            <table class="table table-shopping">
                                <thead>
                                    <tr>
                                        <th class="col-6"></th>
                                        <th class="text-right">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, index) in products" :key="index">
                                        <td class="td-product px-4">
                                            <strong>{{ product.name }}</strong>
                                        </td>
                                        <td class="td-number">
                                            <small>RM</small>{{ product.price }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["promotion", "products"],

        data: function () {
            return {
                type: null
            };
        },

        mounted() {
            this.convertType()
        },
        
        methods: {
            convertType() {
                switch(this.promotion.type) {
                    case 'percentage':
                        this.type = 'Percentage discount'
                        break
                    case 'fixed':
                        this.type = 'Fixed discount amount'
                        break
                    case 'bundled':
                        this.type = 'Bundled products promotion'
                        break
                    default:
                        break
                }
            },


        }
    }
</script>