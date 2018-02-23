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
            error: '',
            member: '',
            role: '',
            project_id: '',
        };
    }

    componentDidMount()
    {
        let current_url = window.location.href;
        let current_id = current_url.split("/").pop();
        this.setState({project_id : current_id});
        axios.get('http://localhost:8000/memberproject/project/' +current_id).then(response => {
            this.setState({ member: response.data });
        })
        .catch(function (error) {
        })
        axios.get('http://localhost:8000/memberproject/projectrole/' +current_id).then(response => {
            this.setState({ role: response.data });
        })
        .catch(function (error) {
        })
        axios.get('http://localhost:8000/project/edit/' + current_id)
        .then(response=> {
            this.setState({ name: response.data.name, information: response.data.information,
                deadline: response.data.deadline, type: response.data.type, status: response.data.status});
        });
    }

    showMember()
    {
        if (this.state.member instanceof Array) {
            return this.state.member.map(function (member) {
                return (<div key={member.id} value={member.id}>{member.name}</div>);
            })
        }
    }

    showRole()
    {
        if (this.state.role instanceof Array) {
            return this.state.role.map(function (role) {
                return (<div key={role.id} value={role.member_id}>{role.role}</div>);
            })
        }
    }

    render()
    {
        return (
            <div>
                <h1>SHOW PROJECT</h1>
                <div className="row">
                    <div className="col-md-6"></div>
                    <div className="col-md-2">
                        <Link to="/display-item" className="btn btn-success">Return to Project</Link>
                    </div>
                </div>
                <div className="col-md-12">
                <table className="table table-hover">
                    <thead>
                    <tr>
                            <th>NAME</th>
                            <th width="300px">INFORMATION</th>
                            <th>DEADLINE</th>
                            <th>TYPE</th>
                            <th>STATUS</th>
                            <th width="200px">MEMBER</th>
                            <th >ROLE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                {this.state.name}
                            </td>
                            <td>
                                {this.state.information}
                            </td>
                            <td>
                                {this.state.deadline}
                            </td>
                            <td>
                                 {this.state.type}
                            </td>
                            <td>
                                 {this.state.status}
                            </td>
                            <td>
                                {this.showMember()}
                            </td> 
                            <td>
                                {this.showRole()}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <form onSubmit={this.handleSubmit}>
                    <Link to={"/add-member-project/"+this.state.project_id} className="btn btn-success">Add Member</Link>
                </form>
                </div>
            </div>
        )
    }
}
export default UpdateProject;