<template >
	<div class="alert mt-5" v-bind:class="{ 'alert-danger': type == 'danger', 'alert-success': type == 'success' }"
			role="alert">
		<h4 class="alert-title" v-if="type == 'danger'">Ops:</h4>
		<h4 class="alert-title" v-if="type == 'success'">Great:</h4>
		<p class="alert-description">
			{{ message}}
		</p>
	</div>
</template>

<script>
export default {
	props: ['message', 'type'],
	mounted(){

	}
}
</script>
