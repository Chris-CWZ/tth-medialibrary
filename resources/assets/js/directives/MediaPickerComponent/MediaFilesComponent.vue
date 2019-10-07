<template>
	<div class="file-component">
		<img :src="file.url" :alt="file.name" v-if="!file.is_dir" class="file-image" style="background-color:#0000001A">
		<div class="file-component-actions">
			<i class="material-icons icon-delete" v-on:click="onFileRemoved">delete</i>
			<i class="material-icons icon-preview" v-on:click="onPreview">remove_red_eye</i>
		</div>

		<lightbox :images="lightboxConfig.images">
	    <lightbox-default-loader slot="loader"></lightbox-default-loader>
		</lightbox>
	</div>
</template>

<script>
export default {
	props: ['file'],
	
	data: function(){
		return {
			lightboxConfig: {
				display: false,
				images: [],
			},
		};
	},

	methods: {
		onFileRemoved: function(){
			this.file.deleted = true;
			this.$emit('media:fileRemoved', this.file);
		},
		onPreview: function(){
			this.lightboxConfig.images = [this.file.url];
			$('.lightbox__thumbnail')[0].click();
		}
	}
}
</script>
