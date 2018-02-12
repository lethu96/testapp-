import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';

class ShowDetailProject extends Component
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
    }

    componentDidMount()
    {
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        console.log(current_id);
        axios.get('http://localhost:8000/project/edit/' + current_id)
        .then(response=> {
            this.setState({ name: response.data.name, information: response.data.information,
                deadline: response.data.deadline, type: response.data.type, status: response.data.status});
        });
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


    render()
    {
        return (
            <div>
                <h1>Detail Project</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/display-item" className="btn btn-success">Return to Project</Link>
                    </div>
                </div>
                <form onSubmit={this.handleSubmit} >
                    <div className="form-group">
                        <label> Name</label>
                        <input type="text"
                        className="form-control"
                        value={this.state.name} disabled/>
                        <p className="help-block" >{this.state.error.name} </p>
                    </div>
                    <div className="form-group">
                        <label name="product_body"> Information</label>
                        <textarea className="form-control" value={this.state.information} disabled></textarea>
                        <p className="help-block" disabled>{this.state.error.information} </p>
                    </div>
                    <div className="form-group">
                        <label> Deadline</label>
                        <input type="date"
                        className="form-control"
                        value={this.state.deadline} disabled/>
                        <p className="help-block" >{this.state.error.deadline} </p>
                    </div>
                    <div className="form-group">
                        <label> Type</label>
                        <select value={this.state.type} className="form-control" disabled>
                            <option value="">---Option---</option>
                            <option value="lab">Lab</option>
                            <option value="single">Single</option>
                            <option value="acceptance">Acceptance</option>
                        </select>
                        <p className="help-block" >{this.state.error.type} </p>
                    </div>
                    <div className="form-group">
                        <label> Status</label>
                        <select value={this.state.status} className="form-control" disabled>
                            <option value="">---Option---</option>
                            <option value="planned">Planned</option>
                            <option value="onhold">Onhold</option>
                            <option value="doing">Doing</option>
                            <option value="done">Done</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <p className="help-block" >{this.state.error.status} </p>
                    </div>
                </form>
                <table className="table table-hover">
                    <thead>
                        <tr>
                            <td>Member</td>
                            <td></td>
                            <td>Information</td>
                            <td>Deadline</td>
                            <td>Type</td>
                            <td>Status</td>
                            <td width="200px">Actions</td>
                        </tr>
                    </thead>
                    <tbody>
                        {this.tabRow()}
                    </tbody>
                </table>
            </div>
        )
    }
}
export default ShowDetailProject;