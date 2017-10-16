<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div id="example"></div>
<script src="/bower_components/react/react.js"></script>
<script src="/bower_components/react/react-dom.js"></script>
<script src="https://cdn.bootcss.com/babel-standalone/6.22.1/babel.min.js"></script>
<script type="text/babel">
    //例子一
/*    function formatName(user){
        return user.firstName + '' +user.lastName;
    }
    const user = {
      firstName : 'song',
      lastName : 'ming',
      url : 'www.baidu.com'
    };
    const element = (
        <a href="{ user.url }"><h1>hello,{ formatName( user ) }!</h1></a>
    );

    ReactDOM.render(
        element,
        document.getElementById('example')
    );*/

    //例子二 做一个计时器
/*    function  tick() {
        const element = (
            <div>
                <h1>欢迎光临!</h1>
                <h2>当前时间:{new Date().toLocaleTimeString()}</h2>
            </div>
        );
        ReactDOM.render(
            element,
            document.getElementById('example')
        )
    }
    setInterval(tick,1000);*/

    // 例子三 组件 & Props
    // 组合组件
/*    function Welcome(props){
        return <h1>你好！{props.name}</h1>
    }

    function App() {
        return (
            <div>
                <Welcome name = '小花'/>
                <Welcome name = '小刚'/>
                <Welcome name = '小路'/>
            </div>
        );
    }

    ReactDOM.render(
        <App/>,
        document.getElementById('example')
    );*/

    // 例子四 State & 生命周期

    class Clock extends React.Component {
        constructor(props) {
            super(props);
            this.state = {date: new Date()};
        }

        componentDidMount() {
            this.timerID = setInterval(
                () => this.tick(),
                1000
            );
        }

        componentWillUnmount() {
            clearInterval(this.timerID);
        }

        tick() {
            this.setState({
                date: new Date()
            });
        }

        render() {
            return (
                    <div>
                        <h1>Hello, world!</h1>
                        <h2>It is {this.state.date.toLocaleTimeString()}.</h2>
                    </div>
            );
        }
    }

    ReactDOM.render(
            <Clock />,
        document.getElementById('example')
    );

</script>
</body>
</html>