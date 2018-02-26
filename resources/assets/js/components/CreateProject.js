import React, {Component} from 'react';
import {browserHistory} from 'react-router';
import { Link } from 'react-router';

class CreateProject extends Component
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
            value:'',
            error:''
        };
        this.handleChangeName = this.handleChangeName.bind(this);
        this.handleChangeInformation = this.handleChangeInformation.bind(this);
        this.handleChangeDeadline = this.handleChangeDeadline.bind(this);
        this.handleChangeType = this.handleChangeType.bind(this);
        this.handleChangeStatus = this.handleChangeStatus.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
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

    handleSubmit(e)
    {
        e.preventDefault();
        axios.post(
            'http://localhost:8000/project/create',
            {
                name: this.state.name,
                information: this.state.information,
                deadline: this.state.deadline,
                type: this.state.type,
                status: this.state.status
            }
        ).then(response => {
            browserHistory.push('/listproject');
            swal("Create Project Success!", {
                    icon: "success",
                    timer: 2000,
                    buttons:false
                });
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
                <h1>CREATE PROJECT</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/listproject" className="btn btn-success">List Project</Link>
                    </div>
                </div><br />
                <form onSubmit={this.handleSubmit}>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Name</label>
                                <input value={this.state.name} type="text" className="form-control" onChange={this.handleChangeName} />
                                <p className="help-block" >{this.state.error.name} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Deadline</label>
                                <input value={this.state.deadline} type="date" className="form-control" onChange={this.handleChangeDeadline} />
                                <p className="help-block" >{this.state.error.deadline} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                            <label>Information</label>
                            <textarea value={this.state.information}className="form-control col-md-6" onChange={this.handleChangeInformation}></textarea>
                            <p className="help-block" >{this.state.error.information} </p>
                        </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Type</label>
                                <select value={this.state.type} className="form-control" onChange={this.handleChangeType}>
                                    <option value="">---Option---</option>
                                    <option value="lab">Lab</option>
                                    <option value="single">Single</option>
                                    <option value="acceptance">Acceptance</option>
                                </select>
                                <p className="help-block" >{this.state.error.type} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Status</label>
                                <select value={this.state.status} className="form-control" onChange={this.handleChangeStatus}>
                                    <option value="">---Option---</option>
                                    <option value="planned">Planned</option>
                                    <option value="onhold">Onhold</option>
                                    <option value="doing">Doing</option>
                                    <option value="done">Done</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <p className="help-block" >{this.state.error.status} </p>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div className="form-group">
                        <button type = "submit" className="btn btn-primary">Add Project</button>
                    </div>
                </form>
            </div>
        )
    }
}
export default CreateProject;