<template >
  <div class="file-picker" id="media-picker">
		<div class="modal fade create-modal" :class="iKey" id="file-picker-modal" tabindex="-1" role="dialog"  aria-hidden="true">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content ">
					<div class="modal-header">
						<h5 class="modal-title" id="">Choose your file</h5>
					</div>
					<div class="modal-body">
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
		props: ['multiple', 'isOpen', "iKey"],
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
				$(`.${this.iKey}`).modal('show');
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

					this.files.push(fileElement);
					this.disabled = false;
					return;
				}
				this.files.push(fileElement);
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
			}
		}
	}
</script>
