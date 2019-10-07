<template>
	<nav aria-label="breadcrumb" class="explorer-nav d-flex flex-row" style="">
	  <ol class="breadcrumb p-0 mb-0">
			<li class="breadcrumb-item active" style="font-weight:bold" aria-current="page" v-for="directory in directories" v-on:click="onLinkClicked(directory)">{{ directory.name }}</li>
	  </ol>
	</nav>
</template>

<script>
	export default {
		props: [],
		data: function(){
			return {
				directories: [
					{
						id: null,
						name: 'Home'
					}
				],
			};
		},
		mounted(){
			VueEventBus.$on('mediaLibrary:fileExplored', this.onFileExplored);
		},
		methods: {
			onFileExplored: function(fileElement){
				let breadcrumb = {
					id: fileElement.id,
					name: fileElement.name
				};
				this.directories.push(breadcrumb);
			},
			onLinkClicked: function(directory){
				let index = _.findIndex(this.directories, function(d) { return d.id == directory.id; });
				let newDirectories = _.slice(this.directories, 0, index + 1);
				this.directories = newDirectories;
				if (directory.id) {
					this.$emit('mediaLibrary:explore', directory.id);
				}
				this.$emit('mediaLibrary:exploreAll');
			}
		}
	}
</script>

<style lang="css">
</style>
