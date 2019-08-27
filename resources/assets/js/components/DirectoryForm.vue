<template>
    <form @submit.prevent="submitForm">
        <div class="card-body">
            <div class="form-group has-label">
                <div class="row">
                    <div class="col-md-6">
                        <label>Category
                            <span class="star">*</span>
                        </label>
                        <select class="form-control" name="category" v-model="category" required>
                            <option disabled>Select category</option>
                            <option value="dining">Dining</option>
                            <option value="museum">Museum</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-label">
                            <label>Name
                                <span class="star">*</span>
                            </label>
                            <input type="text" class="form-control" name="name" v-model="name" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-label">
                            <label>Phone number</label>
                            <input type="text" class="form-control" name="phone-number" v-model="phoneNumber">
                            <div class="invalid-feedback">
                                Numbers only.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group has-label">
                            <label>Level
                                <span class="star">*</span>
                            </label>
                            <input type="text" class="form-control" name="level" v-model="level" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group has-label">
                            <label>Location
                                <span class="star">*</span>
                            </label>
                            <input type="text" class="form-control" name="location" v-model="location" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group has-label">
                            <label>Description
                                <span class="star">*</span>
                            </label>
                            <textarea class="form-control" rows="5" v-model="description" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group has-label">
                            <label>Directory Website URL
                                <span class="star">*</span>
                            </label>
                            <input type="text" class="form-control" name="wesbite" v-model="website" required>
                        </div>
                    </div>
                </div>
                <div class="form-row my-2">
                    <div class="col-md-1">
                        <img v-if="icon.preview" :src="icon.preview" class="border-gray img-thumbnail">
                        <img v-else :src="noImage" class="border-gray img-thumbnail">
                    </div>
                    <div class="col-md-11 my-auto">
                        <div class="form-group has-label">
                            <label>Icon image
                                <span class="star">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="form-control-file is-invalid" @change="onSelectIconImage">
                                <label v-if="icon.name" class="custom-file-label">{{ icon.name }}</label>
                                <label v-else class="custom-file-label is-invalid">Choose file</label>
                            </div>
                            <p v-if="icon.isWrongFileType" class="text-danger font-weight-light">Please select an image
                                file (.png, .jpeg, .jpg)</p>
                        </div>
                    </div>
                </div>
                <div class="form-row my-2">
                    <div class="col-md-1">
                        <img v-if="locationMap.preview" :src="locationMap.preview" class="border-gray img-thumbnail">
                        <img v-else :src="noImage" class="border-gray img-thumbnail">
                    </div>
                    <div class="col-md-11 my-auto">
                        <div class="form-group has-label">
                            <label>Location map image
                                <span class="star">*</span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="form-control-file" @change="onSelectLocationImage">
                                <label v-if="locationMap.name" class="custom-file-label">{{ locationMap.name }}</label>
                                <label v-else class="custom-file-label">Choose file</label>
                            </div>
                            <p v-if="locationMap.isWrongFileType" class="text-danger font-weight-light">Please select an
                                image file (.png, .jpeg, .jpg)</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <label>Banner images</label>
                    </div>
                </div>
                <div v-for="(image, index) in bannerImages" :key="index">
                    <div v-if="image.isDeleted == false">
                        <div class="form-row my-1 no-gutter">
                            <div class="col-md-1">
                                <img v-if="image.preview" :src="image.preview" class="border-gray img-thumbnail">
                                <img v-else :src="noImage" class="border-gray img-thumbnail">
                            </div>
                            <div class="col-md-10 my-auto">
                                <div class="form-group has-label">
                                    <div class="custom-file">
                                        <input type="file" class="form-control-file" @change="onSelectBannerImage($event, index)">
                                        <label v-if="image.name" class="custom-file-label">{{ image.name }}</label>
                                        <label v-else class="custom-file-label">Choose file</label>
                                    </div>
                                    <p v-if="image.isWrongFileType" class="text-danger font-weight-light">Please select an
                                        image file (.png, .jpeg, .jpg)</p>
                                </div>
                            </div>
                            <div class="col-md-1 text-center">
                                <button type="button" class="btn btn-danger btn-icon btn-round" @click="removeBannerInput(index)">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-category form-category">
                <span class="star">*</span> Required fields
            </div>
            <div class="alert alert-danger mt-4" role="alert" v-if="error">
                <ul>
                    <li>{{ error }}</li>
                </ul>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-info btn-fill btn-wd">Submit</button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    props: ["directory", "iconImage", "locationImage", "directoryImages", "directoryImagesPreview"],

    data: function () {
        return {
            category: null,
            name: null,
            phoneNumber: null,
            level: null,
            location: null,
            description: null,
            noImage: '../../../images/noimage.jpg',
            website: null,
            error: null,

            icon: {
                preview: null,
                name: null,
                isWrongFileType: false,
            },

            locationMap: {
                preview: null,
                name: null,
                isWrongFileType: false
            },

            bannerImages: [{
                preview: null,
                name: null,
                isWrongFileType: false,
                isModified: false,
                isDeleted: false
            }],
        };
    },

    mounted() {
        this.fillForm()
    },

    methods: {
        fillForm() {
            if(this.directory != null) {
                this.category = this.directory.category
                this.name = this.directory.name
                this.phoneNumber = this.directory.phone_number
                this.level = this.directory.level
                this.location = this.directory.location
                this.description = this.directory.description
                this.website = this.directory.website

                this.icon = {
                    preview: this.iconImage,
                    name: this.directory.icon,
                    isWrongFileType: false
                }

                this.locationMap = {
                    preview: this.locationImage,
                    name: this.directory.location_image,
                    isWrongFileType: false
                }

                for(var i = 0; i < this.directoryImages.length; i++) {
                    this.bannerImages[i] = {
                        id: this.directoryImages[i].id,
                        preview: this.directoryImagesPreview[i],
                        name: this.directoryImages[i].banner_image,
                        isWrongFileType: false,
                        isModified: false,
                        isDeleted: false
                    }
                }

                this.bannerImages.push({
                    preview: null,
                    name: null,
                    isWrongFileType: false,
                    isModified: false,
                    isDeleted: false
                })

            }
        },

        onSelectIconImage(event) {
            this.icon = {
                name: event.target.files[0].name,
                file: event.target.files[0]
            }

            if(this.isWrongFileType(event.target.files[0].type)) {
                this.icon.isWrongFileType = true
                this.icon.preview = null
            } else {
                this.icon.isWrongFileType = false
                this.icon.preview = URL.createObjectURL(event.target.files[0])
            }
        },

        onSelectLocationImage(event) {
            this.locationMap = {
                name: event.target.files[0].name,
                file: event.target.files[0]
            }

            if(this.isWrongFileType(event.target.files[0].type)) {
                this.locationMap.isWrongFileType = true
                this.locationMap.preview = null
            } else {
                this.locationMap.isWrongFileType = false
                this.locationMap.preview = URL.createObjectURL(event.target.files[0])
            }
        },

        onSelectBannerImage: function (event, index) {
            if(event.target.files[0] != null) {
                if(this.bannerImages[index].name == null) {
                    this.bannerImages.push({
                        preview: null,
                        name: null,
                        isWrongFileType: false,
                        isModified: false,
                        isDeleted: false
                    })
                }

                let image = {
                    name: event.target.files[0].name,
                    file: event.target.files[0],
                    isModified: false,
                    isDeleted: false
                }

                if(this.isWrongFileType(event.target.files[0].type)) {
                    image.isWrongFileType = true
                    image.preview = null
                } else {
                    image.isWrongFileType = false
                    image.preview = URL.createObjectURL(event.target.files[0])
                }

                if(this.bannerImages[index].id) {
                    image.isModified = true
                    image.id = this.bannerImages[index].id
                }

                this.$set(this.bannerImages, index, image)
                console.log(this.bannerImages)
            }         
        },

        removeBannerInput(index) {
            if(this.bannerImages[index].id) {
                this.bannerImages[index].isDeleted = true
                this.$set(this.bannerImages, index, this.bannerImages[index])                
            } else {
                this.bannerImages.splice(index, 1)
            }
            console.log(this.bannerImages)
        },

        isWrongFileType(fileType) {
            if(fileType != 'image/jpeg' && fileType != 'image/jpg' && fileType != 'image/png') {
                return true
            } else {
                return false
            }
        },

        submitForm() {
            var isErrorExist

            for(var i = 0; i < this.bannerImages.length; i++) {
                if(this.bannerImages[i].isWrongFileType) {
                    isErrorExist = true
                } else {
                    isErrorExist = false
                }
            }

            if(!this.icon.isWrongFileType && !this.locationMap.isWrongFileType && !isErrorExist) {
                this.error = null

                if(this.directory) {
                    this.updateFormRequest()
                } else {
                    this.sendFormRequest()                    
                }
            } else {
                this.error = "Please check that all uploaded files are images"
            }
        },

        updateFormRequest() {
            let formData = new FormData();
            formData.set('category', this.category)
            formData.set('name', this.name)
            formData.set('phone_number', this.phoneNumber)
            formData.set('location', this.location)
            formData.set('level', this.level)
            formData.set('description', this.description)
            formData.set('website', this.website)
            formData.append('banner_images', JSON.stringify(this.bannerImages))

            if(this.icon.name != this.directory.icon) {
                formData.append('icon', this.icon.file)                
            }

            if(this.locationMap.name != this.directory.location_image) {
                formData.append('location_image', this.locationMap.file)
            }

            for(var i = 0; i < this.bannerImages.length; i++) {
                if(this.bannerImages[i].name) {
                    var bannerFile = this.bannerImages[i].file
                    formData.append('banner_image_' + i, bannerFile)
                }
            }

            axios.post("/admin/directory/" + this.directory.id, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(({data}) => {
                    location.href = data
                }, (error) => {
                    console.log(error.response)
                });
        },

        sendFormRequest() {
            let formData = new FormData();
            formData.set('category', this.category)
            formData.set('name', this.name)
            formData.set('phone_number', this.phoneNumber)
            formData.set('location', this.location)
            formData.set('level', this.level)
            formData.set('description', this.description)
            formData.set('website', this.website)
            formData.append('icon', this.icon.file)
            formData.append('location_image', this.locationMap.file)

            this.bannerImages.splice(this.bannerImages.length - 1, 1)
            formData.append('banner_images', JSON.stringify(this.bannerImages))

            for(var i = 0; i < this.bannerImages.length; i++) {
                if(this.bannerImages[i].name) {
                    var bannerFile = this.bannerImages[i].file
                    formData.append('banner_image_' + i, bannerFile)
                }
            }

            axios.post("/admin/directory", formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(({data}) => {
                    location.href = data
                }, (error) => {
                    console.log(error.response)
                });
        }
    }
}
</script>
