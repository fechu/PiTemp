#!/usr/bin/env python
import plotly
import os


def update_temp(date,temp):
        py = plotly.plotly(username='USER', key='KEY')
        r =  py.plot(date,temp,
        filename='RPiTempCont',
        fileopt='extend',
        layout={'title': 'Raspberry Pi Temperature Status'})

if __name__ == '__main__':
    import sys
    if len(sys.argv) == 3:
        date = sys.argv[1]
        temp = sys.argv[2]
        update_temp(date,temp)
    else:
        print 'Usage: ' + sys.argv[0] + ' date temp'
