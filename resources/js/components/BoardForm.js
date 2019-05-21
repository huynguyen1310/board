class BoardForm 
{
    constructor(data) {
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this , data);

        this.errors = {};
        this.submited = false;
    }

    data () {
        let data = {};

        for(let attribute in this.originalData) {
            data[attribute] = this[attribute];
        }

        return data;
    }

    post(endpoint) {
        this.submit(endpoint);
    }

    patch(endpoint) {
        this.submit(endpoint , 'patch');
    }

    delete(endpoint) {
        this.submit(endpoint , 'delete');
    }

    submit(endpoint , requestType = 'post') {
        return axios[requestType](endpoint , this.data())
                .catch(this.onFail.bind(this))
                .then(this.onSucces.bind(this));
    }

    onSucces(res) {
        this.submited = true;
        this.errors = {};
        return res;
    }

    onFail(error) {
        this.errors = error.response.data.errors;
        this.submited = false;

        throw error;
    }

    reset() {
        Object.assign(this , this.originalData);
    }
}

export default BoardForm;