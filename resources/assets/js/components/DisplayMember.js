import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import TableRowMember from './TableRowMember';


class DisplayMember extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {value: '', member: ''};
    }

    componentDidMount()
    {
        axios.get('http://localhost:8000/member').then(response => {
            this.setState({ member: response.data });
        })
        .catch(function (error) {
            console.log(error);})
    }

    tabRow()
    {
        if (this.state.member instanceof Array) {
            return this.state.member.map(function (member, i) {
                return <TableRowMember obj={member} key={i} />;
            })
        }
    }

    render()
    {
        return (
            <div>
                <h1> List Member</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/add-item-member">Create Member</Link>
                    </div>
                </div><br />
                <table className="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Information</td>
                            <td>Phone Number</td>
                            <td>Birthday</td>
                            <td>Gender</td>
                            <td>Position</td>
                            <td>Avatar</td>
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
export default DisplayMember;