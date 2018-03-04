import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';


class UpdateProject extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            name: '',
            information: '',
            deadline: '',
            type: '',
            status: '',
            error: ''
        };
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeInformation = this.handleChangeInformation.bind(this);
        this.handleChangeDeadline = this.handleChangeDeadline.bind(this);
        this.handleChangeType = this.handleChangeType.bind(this);
        this.handleChangeStatus = this.handleChangeStatus.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount()
    {
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        console.log(current_url);
        axios.get('http://localhost:8000/project/' + current_id)
        .then(response=> {
            this.setState({ name: response.data.name, information: response.data.information,
                deadline: response.data.deadline, type: response.data.type, status: response.data.status});
        })
    }

    handleChangeName(e)
    {
        this.setState({
            name: e.target.value
        })
    }

    handleChangeInformation(e)
    {
        this.setState({
            information: e.target.value
        })
    }

    handleChangeDeadline(e)
    {
        this.setState({
            deadline: e.target.value
        })
    }

    handleChangeType(e)
    {
        this.setState({
            type: e.target.value
        })
    }

    handleChangeStatus(e)
    {
        this.setState({
            status: e.target.value
        })
    }

    handleSubmit(event)
    {
        event.preventDefault();
        const project = {
            name: this.state.name,
            information: this.state.information,
            deadline: this.state.deadline,
            type: this.state.type,
            status: this.state.status
        }
        let uri = 'http://localhost:8000/project/'+this.props.params.id;
        axios.put(uri, project).then((response) => {
            swal("Update Project Success", {
                    icon: "success",
                    timer: 1000,
                    buttons:false
                });
            this.props.history.push('/display-item');
        }).catch(error => {
            if (error.response) {
                this.setState({ error: error.response.data.errors });
            }
        });
    }

    render()
    {
        return (
            <div>
                <h1>Update Project</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/display-item" className="btn btn-success">Return to Project</Link>
                    </div>
                </div>
                <form onSubmit={this.handleSubmit} >
                    <div className="form-group">
                        <label>Project Name</label>
                        <input type="text"
                        className="form-control"
                        value={this.state.name}
                        onChange={this.handleChangeName} />
                        <p className="help-block" >{this.state.error.name} </p>
                    </div>
                    <div className="form-group">
                        <label name="product_body">Project Information</label>
                        <textarea className="form-control"
                        onChange={this.handleChangeInformation} value={this.state.information}></textarea>
                        <p className="help-block" >{this.state.error.information} </p>
                    </div>
                    <div className="form-group">
                        <label>Project Deadline</label>
                        <input type="date"
                        className="form-control"
                        value={this.state.deadline}
                        onChange={this.handleChangeDeadline} />
                        <p className="help-block" >{this.state.error.deadline} </p>
                    </div>
                    <div className="form-group">
                        <label>Project Type</label>
                        <select value={this.state.type} className="form-control" onChange={this.handleChangeType}>
                            <option value="">---Option---</option>
                            <option value="lab">lab</option>
                            <option value="single">single</option>
                            <option value="acceptance">acceptance</option>
                        </select>
                        <p className="help-block" >{this.state.error.type} </p>
                    </div>
                    <div className="form-group">
                        <label>Project Status</label>
                        <select value={this.state.status} className="form-control" onChange={this.handleChangeStatus}>
                            <option value="">---Option---</option>
                            <option value="planned">planned</option>
                            <option value="onhold">onhold</option>
                            <option value="doing">doing</option>
                            <option value="done">done</option>
                            <option value="cancelled">cancelled</option>
                        </select>
                        <p className="help-block" >{this.state.error.status} </p>
                    </div>
                    <div className="form-group">
                        <button className="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        )
    }
}
export default UpdateProject;