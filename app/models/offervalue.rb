# == Schema Information
#
# Table name: offervalues
#
#  id         :integer(4)      not null, primary key
#  time       :string(255)
#  monday     :float
#  tuesday    :float
#  wednesday  :float
#  thursday   :float
#  friday     :float
#  saturday   :float
#  sunday     :float
#  created_at :datetime
#  updated_at :datetime
#

class Offervalue < ActiveRecord::Base
	
	# convert time to float type. ex: 0030 -> 00.30
  def hour
  	hour = time[0, 2] + "." + time[2, 2]
  end #end hour method
end
