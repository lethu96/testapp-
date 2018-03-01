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
        this.updateState = this.updateState.bind(this);
    }

    componentDidMount()
    {
        axios.get('http://localhost:8000/member').then(response => {
            this.setState({ member: response.data });
        })
    }

    updateState(newlist)
    {
        this.setState({member :newlist});
    }

    tabRow()
    {
        if (this.state.member instanceof Array) {
            return this.state.member.map((member, i) => {
                return <TableRowMember obj={member} key={i} newlist ={this.updateState}/>;
            })
        }
    }

    render()
    {
        return (
            <div>
                <h1> LIST MEMBER</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/add-item-member" className="btn btn-success">Create Member</Link>
                    </div>
                </div><br />
                <table className="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>INFORMATION</th>
                            <th>PHONE NUMBER</th>
                            <th>BIRTHDAY</th>
                            <th>GENDER</th>
                            <th>POSITION</th>
                            <th>AVATAR</th>
                            <th>ACTIONS</th>
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