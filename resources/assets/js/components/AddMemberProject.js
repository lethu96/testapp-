import React, {Component} from 'react';
import {browserHistory} from 'react-router';


class AddMemberProject extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            selectedmember_id:'',
            project_id: '',
            role: '',
            error:'',
            message: '',
            isButtonDisabled: false
        };
        this.handleChangemember_id = this.handleChangemember_id.bind(this);
        this.handleChangeRole = this.handleChangeRole.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
    }

    componentDidMount()
    {
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        this.setState({project_id: current_id});
        axios.get('http://localhost:8000/member').then(response => {
            this.setState({ member: response.data });
        })
    }

    showMember()
    {
        if (this.state.member instanceof Array) {
            return this.state.member.map(function (member) {
                return (<option key={member.id} value={member.id}>{member.name}</option>);
            })
        }
    }

    handleChangemember_id(e)
    {
        this.setState({
            selectedmember_id: e.target.value
        })
    }

    handleChangeRole(e)
    {
        this.setState({
            role: e.target.value
        })
    }

    handleSubmit(e)
    {
        e.preventDefault();
        let data = new FormData();
        data.append('project_id', this.state.project_id)
        data.append('member_id', this.state.selectedmember_id)
        data.append('role', this.state.role)
        axios.post('http://localhost:8000/member_projects/', data)
        .then(
            (response) => {browserHistory.push('/show-detail-item/'+this.state.project_id);
        }).catch(error => {
            if (error.response) {
                this.setState({ error: error.response.data.errors , isButtonDisabled: false});
            }
        });
    }

    render()
    {
        return (
            <div>
                <h1>Add Member Project</h1>
                <form onSubmit={this.handleSubmit}>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Member </label>
                                <select  className="form-control" onChange={this.handleChangemember_id}>
                                <p className="help-block" >{this.state.error.member_id} </p>
                                 <option value="">---Option---</option>
                                    {this.showMember()}
                                </select>
                                <p className="help-block" >{this.state.error.member_id} </p>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-md-6">
                            <div className="form-group">
                                <label>Role</label>
                                <select className="form-control" onChange={this.handleChangeRole}>
                                    <option value="">---Option---</option>
                                    <option value="pm">pm</option>
                                    <option value="dev">dev</option>
                                    <option value="sm">sm</option>
                                    <option value="po">po</option>
                                    <option value="pl">pl</option>
                                </select>
                                <p className="help-block" >{this.state.error.role} </p>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div className="form-group">
                        <button type = "submit" className="btn btn-primary" disabled={this.state.isButtonDisabled}>Add Member</button>
                    </div>
                </form>
            </div>
        )
    }
}
export default AddMemberProject;