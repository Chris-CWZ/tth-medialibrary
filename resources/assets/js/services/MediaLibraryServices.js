export default {
	getFileElements(onSuccess, onError){
		axios.get(`/admin/explorers/`)
		.then(({ data }) => {
			onSuccess(data);
		}, ({ response }) => {
			this.handleErrorResponse(response, onError);
        });
	},
	getFileElement(id ,onSuccess, onError){
		axios.get(`/admin/explorers/${id}`)
		.then(({ data }) => {
			onSuccess(data);
		}, ({ response }) => {
			this.handleErrorResponse(response, onError);
		});
	},
	removeFileElement(id, onSuccess, onError){
		axios.delete(`/admin/explorers/${id}`)
		.then(({ data }) => {
            console.log(data);
			onSuccess(data);
		}, (error) => {
			this.handleErrorResponse(response, onError);
		});
	},
	createFileElement(data, onSuccess, onError){
		axios.post(`/admin/explorers`, data)
		.then(({ data }) => {
			onSuccess(data);
		}, (error) => {
			this.handleErrorResponse(response, onError);
		});
	},
	renameFileElement(id, data, onSuccess, onError){
		axios.patch(`/admin/explorers/${id}/rename`, data)
		.then(({ data }) => {
			onSuccess(data);
		}, (error) => {
			this.handleErrorResponse(response, onError);
		});
	},
	moveFileElement(id, data, onSuccess, onError){
		axios.patch(`/admin/explorers/${id}/move`, data)
		.then(({ data }) => {
			onSuccess(data);
		}, (error) => {
			this.handleErrorResponse(response, onError);
		});
	},
	handleErrorResponse(response, onError){
		if (response.status === 401) {
			location.reload();
		}
		onError(response);
	}
}
