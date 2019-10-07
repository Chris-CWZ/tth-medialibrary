<template>
	<div class="modal fade create-modal" id="rename-dir-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="">Rename Directory</h5>
				</div>
				<div class="modal-body">
					<div class="has-error py-2" v-if="hasError">
						{{ hasError }}
					</div>
					<div class="form-group">
						<label for="directory">Directory Name</label>
						<input type="text" class="form-control" id="directory" aria-describedby="directoryHelp"
									 placeholder="Enter Directory Name" v-on:input="disabled = false" v-model="name">
					</div>
				</div>
				<div class="modal-footer d-flex">
					<button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal" v-on:click="dismissModal">
						Close
					</button>
					<button type="button" class="btn btn-primary" v-bind:class="{ disabled: disabled }" style="margin-left:10px;"  v-on:click="onConfirm">
						Confirm
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: [],
	data: function(){
		return {
			fileElement: null,
			disabled: true,
			name: null,
			hasError: null
		}
	},
	mounted(){
		this.eventsHandlers();
	},
	methods: {
		eventsHandlers: function(){
			VueEventBus.$on('openDirectoryNameModal', this.openModal);
		},
		openModal: function(fileElement){
			this.fileElement = fileElement;
			this.name = fileElement.name;
			console.log("Modal :: ", this.fileElement.name);
			$('#rename-dir-modal').modal('show');
		},
		dismissModal: function(){
			this.name = this.fileElement.name;
			this.disabled = true;
			$('#rename-dir-modal').modal('hide');
		},
		onConfirm: function(){
			if (this.disabled) {
				return ;
			}
			if (this.fileElement.name === this.name) {
				this.hasError = 'No Changes Made';
				return ;
			}
			VueEventBus.$emit('directoryNameChanged', this.fileElement, this.name);
			this.dismissModal();
		}
	}
}
</script>

<style>
</style>
