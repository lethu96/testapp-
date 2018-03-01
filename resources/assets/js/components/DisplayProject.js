import React, {Component} from 'react';
import axios from 'axios';
import { Link } from 'react-router';
import TableRow from './TableRow';


class DisplayProject extends Component
{
    constructor(props)
    {
        super(props);
        this.state = {value: '', project: ''};
        this.updateState = this.updateState.bind(this);
    }

    componentDidMount()
    {
        axios.get('http://localhost:8000/project')
        .then(response => {
                this.setState({ project: response.data });
            })
    }

    updateState(newlist)
    {
        this.setState({project :newlist});
    }

    tabRow()
    {
        if (this.state.project instanceof Array) {
            return this.state.project.map((object, i) =>{
                return <TableRow project={object}  key={i} newlist ={this.updateState}/>;
            })
        }
    }

    render()
    {
        return (
            <div>
                <h1>LIST PROJECT</h1>
                <div className="row">
                    <div className="col-md-10"></div>
                    <div className="col-md-2">
                        <Link to="/add-item" className="btn btn-success">Create Projects</Link>
                    </div>
                </div><br />
                <table className="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>INFORMATION</th>
                            <th>DEADLINE</th>
                            <th>TYPE</th>
                            <th>STATUS</th>
                            <th width="200px">ACTIONS</th>
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
export default DisplayProject;