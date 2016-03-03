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

require 'test_helper'

class OffervalueTest < ActiveSupport::TestCase
  # test "the truth" do
  #   assert true
  # end
end
