<template >
  <div class="file-picker" id="media-picker">
		<div class="modal fade create-modal" :class="iKey" id="file-picker-modal" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content" style="background-color:#efeff5">
					<div class="modal-header" style="padding:24px">
						<h5 class="modal-title" style="color:#3f3f3f" id="">Choose your file</h5>
					</div>
					<div class="modal-body pt-0">
						<media-library-component @mediaLibrary:fileSelected="onFileSelected" @mediaLibrary:fileDeselected="onFileDeselected"></media-library-component>
					</div>
					<div class="modal-footer d-flex">
						<button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal" v-on:click="dismissModal">
							Close
						</button>
						<button type="button" class="btn btn-primary" v-bind:class="{ disabled: disabled }" style="margin-left:10px; " v-on:click="onConfirm">
							Select
						</button>
					</div>
				</div>
			</div>
		</div>
  </div>
</template>

<script>
	export default {
		props: ['multiple', 'isOpen', "iKey", "max"],
		data: function(){
			return {
				disabled: true,
				files: []
			};
		},
		watch: {
			isOpen: function(newVal, oldVal){
				if (newVal) {
					this.openModal();
				}else{
					this.dismissModal();
				}
			}
		},
		mounted(){
			if (this.isOpen) {
				this.openModal();
			}
			VueEventBus.$on('resetMediaPicker', this.onResetMediaPicker);
		},
		methods: {
			openModal: function(){
				let self = this;
				$(`.${this.iKey}`).modal('show');
				$(`.${this.iKey}`).on('hide.bs.modal', () => {
					self.$emit('closing');
					
				});
			},
			dismissModal: function(){
				this.files = [];
				this.disabled = true;
				$(`.${this.iKey}`).modal('hide');
				VueEventBus.$emit('mediaLibrary:pickerReset');
			},
			onConfirm: function(){
				if (this.files.length > 0) {
					this.$emit('mediaLibrary:filesSelected', this.files);
					this.dismissModal();
				}
			},
			onFileSelected: function(fileElement){
				if (!this.multiple) {
					if (this.files.length != 0) {
						let previousFileElement = _.head(this.files);
						VueEventBus.$emit('mediaLibrary:fileElementOverridden', previousFileElement);
						this.files = [];
					}
					this.files.push(fileElement)
					this.disabled = false
					return;
				}
				if(this.max){
					let nonDeletedFileCount = 0
					this.files.forEach(function(file){
						if(!file.deleted){
							nonDeletedFileCount += 1;
						}
					})

					if(nonDeletedFileCount < this.max){
						this.files.push(fileElement);
					}
				}else{
					this.files.push(fileElement);
				}
					
				this.disabled = false;
			},
			onFileDeselected: function(fileElement){
				let files = _.reject(this.files, function(file){
					return file.id === fileElement.id;
				});
				this.files = files;
				if (this.files.length == 0) {
					this.disabled = true;
				}
			},
			onResetMediaPicker: function(){
				this.files = [];
			},
		}
	}
</script>
