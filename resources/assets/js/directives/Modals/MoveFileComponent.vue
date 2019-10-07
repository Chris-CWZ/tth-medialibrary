<template>
	<div class="modal fade create-modal" id="move-file-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="">Move File {{ fileElement.name }}</h5>
				</div>
				<div class="modal-body">
					<div class="has-error py-2" v-if="hasError">
						{{ hasError }}
					</div>
					<div class="form-group">
						<label for="directory">Target Directory Name</label>
						<select class="custom-select" v-model="selectedDirectory" v-on:change="disabled = false">
							<option selected="selected" value="-1">Select a target directory</option>
							<option value="null" v-if="fileElement.parent_id != null">Media Library</option>
							<option v-for="targetDirectory in targetDirectories" :value="targetDirectory.id">
								{{ targetDirectory.name }}
							</option>
					  </select>
					</div>
				</div>
				<div class="modal-footer d-flex">
					<button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal" v-on:click="dismissModal">
						Close
					</button>
					<button type="button" class="btn btn-primary" v-bind:class="{ disabled: disabled }" style="margin-left:10px;" v-on:click="onConfirm">
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
			fileElement: {},
			disabled: true,
			hasError: null,
			selectedDirectory: -1,
			targetDirectories: [],
		}
	},
	mounted(){
		this.eventsHandlers();
	},
	methods: {
		eventsHandlers: function(){
			VueEventBus.$on('openFileMoveModal', this.openModal);
		},
		openModal: function(fileElement){
			this.fileElement = fileElement;
			this.fetchTargetDirectories();
			$('#move-file-modal').modal('show');
		},
		dismissModal: function(){
			this.disabled = true;
			this.targetDirectories = [];
			this.selectedDirectory = -1;
			$('#move-file-modal').modal('hide');
		},
		onConfirm: function(){
			if (this.disabled || this.selectedDirectory === -1) {
				return ;
			}
			VueEventBus.$emit('moveFileElement', this.fileElement, this.selectedDirectory);
			this.dismissModal();
		},
		fetchTargetDirectories: function(){
			axios.get("/admin/explorers?element=" + this.fileElement.id)
			.then(({ data }) => {
				this.targetDirectories = data;
			}, (errorMessage) => {
				console.error(errorMessage);
			});
		}
	}
}
</script>
